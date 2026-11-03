<?php

// 1. Arahkan Storage dan Cache ke direktori /tmp yang memiliki akses Tulis (Writeable)
$appStorage = '/tmp/storage';
if (!is_dir($appStorage)) {
    mkdir($appStorage . '/framework/views', 0755, true);
    mkdir($appStorage . '/framework/sessions', 0755, true);
    mkdir($appStorage . '/framework/cache', 0755, true);
    mkdir($appStorage . '/logs', 0755, true);
}

putenv("APP_STORAGE={$appStorage}");
putenv("VIEW_COMPILED_PATH={$appStorage}/framework/views");

// 2. Load Autoload & App Laravel
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

// 3. Bind Custom Storage Path ke Container Laravel
$app->useStoragePath($appStorage);

// 4. Jalankan Request Kernel
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);