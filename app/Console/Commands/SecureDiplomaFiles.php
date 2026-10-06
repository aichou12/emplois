<?php

namespace App\Console\Commands;

use App\Models\Userdata;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SecureDiplomaFiles extends Command
{
    protected $signature = 'userdata:secure-diplomas {--apply : Copier les fichiers, actualiser les chemins et retirer les copies publiques}';
    protected $description = 'Transfère les justificatifs de diplôme publics vers le stockage privé';

    public function handle(): int
    {
        $apply = (bool) $this->option('apply');
        $disk = Storage::disk('local');
        $changes = 0;
        $missing = 0;
        $movedSources = [];

        Userdata::query()->orderBy('id')->chunkById(100, function ($rows) use ($apply, $disk, &$changes, &$missing, &$movedSources) {
            foreach ($rows as $row) {
                $dirty = false;
                $formations = json_decode((string) $row->autresdiplomes, true);
                if (is_array($formations)) {
                    foreach ($formations as &$formation) {
                        if (is_array($formation) && !empty($formation['diplome_file'])) {
                            $formation['diplome_file'] = $this->securePath($formation['diplome_file'], $row, $apply, $disk, $changes, $missing, $movedSources, $dirty);
                        }
                    }
                    unset($formation);
                    if ($dirty && $apply) $row->autresdiplomes = json_encode($formations, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                }

                $legacy = json_decode((string) $row->diplome_file, true);
                if (is_array($legacy)) {
                    $legacyDirty = false;
                    foreach ($legacy as &$path) {
                        if (is_string($path) && $path !== '') {
                            $path = $this->securePath($path, $row, $apply, $disk, $changes, $missing, $movedSources, $legacyDirty);
                        }
                    }
                    unset($path);
                    if ($legacyDirty && $apply) {
                        $row->diplome_file = json_encode(array_values($legacy), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                        $dirty = true;
                    }
                } elseif (is_string($row->diplome_file) && $row->diplome_file !== '') {
                    $legacyDirty = false;
                    $newPath = $this->securePath($row->diplome_file, $row, $apply, $disk, $changes, $missing, $movedSources, $legacyDirty);
                    if ($legacyDirty && $apply) {
                        $row->diplome_file = $newPath;
                        $dirty = true;
                    }
                }

                if ($dirty && $apply) $row->save();
            }
        });

        if ($apply) {
            foreach (array_keys($movedSources) as $source) File::delete($source);
            // Preserve any legacy file that was not referenced by a profile, but remove its public URL.
            foreach (['diplome', 'diplomes'] as $folder) {
                $publicDir = public_path('uploads/' . $folder);
                if (!File::isDirectory($publicDir)) continue;
                foreach (File::allFiles($publicDir) as $source) {
                    $absolute = $source->getRealPath();
                    if (isset($movedSources[$absolute])) continue;
                    $name = Str::uuid() . ($source->getExtension() ? '.' . strtolower($source->getExtension()) : '');
                    $target = 'diplomes/_archive/' . $folder . '/' . $name;
                    if ($disk->put($target, File::get($absolute))) File::delete($absolute);
                }
            }
        }

        $this->info(($apply ? 'Transfert terminé.' : 'Simulation terminée. Lancez avec --apply pour effectuer le transfert.') . " Références à migrer : {$changes}. Fichiers référencés manquants : {$missing}.");
        return $missing > 0 ? self::FAILURE : self::SUCCESS;
    }

    private function securePath(string $value, Userdata $row, bool $apply, $disk, int &$changes, int &$missing, array &$movedSources, bool &$changed): string
    {
        $path = parse_url($value, PHP_URL_PATH) ?: $value;
        $path = ltrim(str_replace('\\', '/', $path), '/');
        $path = preg_replace('#^(?:public/)?#', '', $path);
        if (str_starts_with($path, 'diplomes/' . $row->utilisateur_id . '/')) return $value;
        if (!preg_match('#^uploads/diplomes?/(.+)$#', $path, $match)) return $value;
        $changes++;

        $source = public_path($path);
        if (!File::isFile($source)) {
            $missing++;
            $this->warn("Fichier référencé introuvable (profil {$row->id}) : {$path}");
            return $value;
        }
        $absolute = realpath($source);
        $publicRoot = realpath(public_path('uploads'));
        if (!$absolute || !$publicRoot || !str_starts_with($absolute, $publicRoot . DIRECTORY_SEPARATOR)) {
            $missing++;
            $this->warn("Chemin public ignoré (profil {$row->id}) : {$path}");
            return $value;
        }

        $extension = strtolower(pathinfo($absolute, PATHINFO_EXTENSION));
        $target = 'diplomes/' . $row->utilisateur_id . '/' . Str::uuid() . ($extension ? '.' . $extension : '');
        if (!$apply) {
            $changed = true;
            return $target;
        }
        if (!$disk->put($target, File::get($absolute))) {
            $missing++;
            return $value;
        }
        $movedSources[$absolute] = true;
        $changed = true;
        return $target;
    }
}
