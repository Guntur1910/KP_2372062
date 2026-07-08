<?php
$zip = new ZipArchive();
$filename = __DIR__ . '/../WEBSITE DIGITALISASI MOTIF KAIN TENUN SUMBA UNTUK INOVASI DESAIN AKSESORIS INTERIOR.docx';

if ($zip->open($filename) === TRUE) {
    $xml = $zip->getFromName('word/document.xml');
    if ($xml) {
        // Simple XML parser to get paragraphs and text
        $dom = new DOMDocument();
        @$dom->loadXML($xml);
        $paragraphs = $dom->getElementsByTagNameNS('http://schemas.openxmlformats.org/wordprocessingml/2006/main', 'p');
        
        $output = '';
        foreach ($paragraphs as $p) {
            $texts = $p->getElementsByTagNameNS('http://schemas.openxmlformats.org/wordprocessingml/2006/main', 't');
            $pText = '';
            foreach ($texts as $t) {
                $pText .= $t->nodeValue;
            }
            $output .= $pText . "\n";
        }
        
        file_put_contents(__DIR__ . '/template_extracted.txt', html_entity_decode($output));
        echo "Successfully extracted text! Length: " . strlen($output) . " characters.\n";
    } else {
        echo "Could not find word/document.xml in ZIP.\n";
    }
    $zip->close();
} else {
    echo "Failed to open ZIP archive: " . $filename . "\n";
}
