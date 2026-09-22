<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$u = \App\Models\Userdata::find(1369022);
if ($u) {
    echo "diplome_file raw: " . var_export($u->diplome_file, true) . PHP_EOL;
    $decoded = json_decode($u->diplome_file, true);
    echo "diplome_file decoded: " . var_export($decoded, true) . PHP_EOL;
} else {
    echo "Userdata 1369022 not found." . PHP_EOL;
}
