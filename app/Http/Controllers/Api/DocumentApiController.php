<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Userdata;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class DocumentApiController extends Controller
{
    /**
     * Récupère ou initialise l'enregistrement Userdata de l'utilisateur connecté.
     */
    protected function getOrCreateUserdata(int $userId): Userdata
    {
        $userdata = Userdata::where('utilisateur_id', $userId)->first();

        if (!$userdata) {
            $userdata = Userdata::create([
                'utilisateur_id' => $userId,
                'lieuresidence' => 'Sénégal',
            ]);
        }

        return $userdata;
    }

    /**
     * Téléversement ou remplacement de la photo de profil.
     */
    public function uploadPhoto(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'photo' => 'required|image|mimes:jpeg,png,jpg,webp|max:4096',
        ], [
            'photo.required' => 'Veuillez sélectionner une photo.',
            'photo.image' => 'Le fichier doit être une image valide.',
            'photo.mimes' => 'Les formats autorisés sont : JPEG, PNG, JPG et WEBP.',
            'photo.max' => 'La photo ne doit pas dépasser 4 Mo.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du téléversement de la photo.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = $request->user();
        $userdata = $this->getOrCreateUserdata($user->id);

        $file = $request->file('photo');
        $fileName = 'avatar_' . $user->id . '_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
        $destDir = public_path('uploads/photos');

        if (!File::exists($destDir)) {
            File::makeDirectory($destDir, 0755, true);
        }

        // Suppression de l'ancienne photo si elle existe et n'est pas l'image par défaut
        if ($userdata->photo_profil && !str_contains($userdata->photo_profil, 'images.png')) {
            $oldPath = public_path($userdata->photo_profil);
            if (File::exists($oldPath)) {
                File::delete($oldPath);
            }
        }

        $file->move($destDir, $fileName);
        $relativePath = 'uploads/photos/' . $fileName;

        $userdata->update(['photo_profil' => $relativePath]);

        return response()->json([
            'success' => true,
            'message' => 'Photo de profil mise à jour avec succès.',
            'data' => [
                'photo_path' => $relativePath,
                'photo_url' => asset($relativePath),
            ],
        ], 200);
    }

    /**
     * Téléversement d'un document CV (PDF, DOC, DOCX).
     */
    public function uploadCv(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'cv_file' => 'required|file|mimes:pdf,doc,docx,rtf,txt|max:8192',
        ], [
            'cv_file.required' => 'Veuillez sélectionner un fichier CV.',
            'cv_file.mimes' => 'Le format du CV doit être PDF, DOC, DOCX, RTF ou TXT.',
            'cv_file.max' => 'La taille du document ne doit pas dépasser 8 Mo.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du téléversement du CV.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = $request->user();
        $userdata = $this->getOrCreateUserdata($user->id);

        $file = $request->file('cv_file');
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $cleanName = Str::slug(substr($originalName, 0, 30));
        $fileName = 'cv_' . $user->id . '_' . time() . '_' . $cleanName . '.' . $file->getClientOriginalExtension();
        $destDir = public_path('uploads/cv');

        if (!File::exists($destDir)) {
            File::makeDirectory($destDir, 0755, true);
        }

        $file->move($destDir, $fileName);
        $relativePath = 'uploads/cv/' . $fileName;

        // Gestion de la liste des CVs enregistrés
        $existingCvs = [];
        if (!empty($userdata->cv_file)) {
            $raw = is_array($userdata->cv_file) ? $userdata->cv_file : json_decode($userdata->cv_file, true);
            if (is_array($raw)) {
                $existingCvs = $raw;
            } elseif (is_string($userdata->cv_file)) {
                $existingCvs = [$userdata->cv_file];
            }
        }

        $existingCvs[] = $relativePath;
        $userdata->update(['cv_file' => json_encode(array_values(array_unique($existingCvs)))]);

        return response()->json([
            'success' => true,
            'message' => 'Curriculum Vitae téléversé avec succès.',
            'data' => [
                'file_path' => $relativePath,
                'file_url' => asset($relativePath),
                'file_name' => basename($relativePath),
            ],
        ], 201);
    }

    /**
     * Suppression d'un document CV.
     */
    public function deleteCv(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'file_path' => 'required|string',
        ], [
            'file_path.required' => 'Le chemin du fichier à supprimer est obligatoire.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Paramètre manquant.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = $request->user();
        $userdata = $this->getOrCreateUserdata($user->id);
        $targetPath = $request->input('file_path');

        $existingCvs = [];
        if (!empty($userdata->cv_file)) {
            $raw = is_array($userdata->cv_file) ? $userdata->cv_file : json_decode($userdata->cv_file, true);
            if (is_array($raw)) {
                $existingCvs = $raw;
            } elseif (is_string($userdata->cv_file)) {
                $existingCvs = [$userdata->cv_file];
            }
        }

        // Retrait de la liste
        $newCvs = array_filter($existingCvs, function ($path) use ($targetPath) {
            return $path !== $targetPath;
        });

        // Suppression physique du fichier sur le disque
        $diskPath = public_path($targetPath);
        if (File::exists($diskPath)) {
            File::delete($diskPath);
        }

        $userdata->update([
            'cv_file' => !empty($newCvs) ? json_encode(array_values($newCvs)) : null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Document CV supprimé avec succès.',
        ], 200);
    }

    /**
     * Téléversement d'un justificatif de diplôme / attestation.
     */
    public function uploadDiplome(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'diplome_file' => 'required|file|mimes:pdf,doc,docx,rtf,txt,png,jpg,jpeg|max:8192',
        ], [
            'diplome_file.required' => 'Veuillez sélectionner un justificatif.',
            'diplome_file.mimes' => 'Le document doit être au format PDF, DOC, DOCX, JPG ou PNG.',
            'diplome_file.max' => 'La taille du document ne doit pas dépasser 8 Mo.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du téléversement du justificatif.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = $request->user();
        $file = $request->file('diplome_file');
        $fileName = 'diplome_' . $user->id . '_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
        $destDir = public_path('uploads/diplomes');

        if (!File::exists($destDir)) {
            File::makeDirectory($destDir, 0755, true);
        }

        $file->move($destDir, $fileName);
        $relativePath = 'uploads/diplomes/' . $fileName;

        return response()->json([
            'success' => true,
            'message' => 'Justificatif de diplôme téléversé.',
            'data' => [
                'file_path' => $relativePath,
                'file_url' => asset($relativePath),
                'file_name' => basename($relativePath),
            ],
        ], 201);
    }
}
