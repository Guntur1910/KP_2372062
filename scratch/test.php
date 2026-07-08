<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Kain;

$kains = Kain::with('motifs')->get()->take(5);
foreach ($kains as $kain) {
    $firstMotif = $kain->motifs->first();
    echo $kain->nama_kain . " first motif image: " . ($firstMotif ? $firstMotif->gambar : "No motif") . "\n";
}
