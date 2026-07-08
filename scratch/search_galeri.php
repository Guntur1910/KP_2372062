<?php
function searchFolder($dir, $pattern) {
    $results = [];
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    foreach ($iterator as $file) {
        if ($file->isDir()) continue;
        $content = file_get_contents($file->getPathname());
        if (strpos($content, $pattern) !== false) {
            $results[] = $file->getPathname();
        }
    }
    return $results;
}

$dirs = [
    __DIR__ . '/../app',
    __DIR__ . '/../routes',
    __DIR__ . '/../resources/views'
];

foreach ($dirs as $dir) {
    if (is_dir($dir)) {
        echo "Searching in $dir...\n";
        $found = searchFolder($dir, 'galeri');
        foreach ($found as $f) {
            echo "Found in: $f\n";
        }
    }
}
