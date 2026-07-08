<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Http\Request;

$request = Request::create('/', 'GET');
$response = $app->handle($request);
$html = $response->getContent();

$dom = new DOMDocument();
@$dom->loadHTML($html);
$xpath = new DOMXPath($dom);

$slideshow1 = $xpath->query('//div[@id="slideshow-1"]');
if ($slideshow1->length > 0) {
    echo "=== slideshow-1 ===\n";
    foreach ($slideshow1->item(0)->childNodes as $child) {
        if ($child->nodeName === 'img') {
            echo "IMG: " . $child->getAttribute('src') . "\n";
        }
    }
} else {
    echo "slideshow-1 not found\n";
}

$slideshow2 = $xpath->query('//div[@id="slideshow-2"]');
if ($slideshow2->length > 0) {
    echo "=== slideshow-2 ===\n";
    foreach ($slideshow2->item(0)->childNodes as $child) {
        if ($child->nodeName === 'img') {
            echo "IMG: " . $child->getAttribute('src') . "\n";
        }
    }
} else {
    echo "slideshow-2 not found\n";
}
