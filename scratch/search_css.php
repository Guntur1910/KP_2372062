<?php
$content = file_get_contents(__DIR__ . '/../public/css/user.css');
$lines = explode("\n", $content);
foreach ($lines as $i => $line) {
    if (strpos($line, 'slide-img') !== false || strpos($line, 'split-image') !== false) {
        echo "Line " . ($i + 1) . ": " . trim($line) . "\n";
    }
}
