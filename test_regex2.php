<?php
$content = file_get_contents('resources/views/pages/spd/print.blade.php');
$lines = explode("\n", $content);
$pattern = '/<div class="labelrow">\s*<span>(.*?)<\/span>\s*<span>(.*?)<\/span>\s*<\/div>/s';
preg_match_all($pattern, $content, $matches);

$allLabelrows = [];
foreach ($lines as $i => $line) {
    if (strpos($line, 'labelrow') !== false) {
        // Just print the line
        // Wait, let's just find the ones that don't match the standard pattern by extracting all and comparing
    }
}
// We can just dump the ones that have class="labelrow" but don't match the regex.
$parts = explode('class="labelrow"', $content);
array_shift($parts); // remove the first part before first labelrow

$unmatched = [];
foreach ($parts as $part) {
    $block = 'class="labelrow"' . substr($part, 0, 300);
    if (!preg_match('/class="labelrow">\s*<span>(.*?)<\/span>\s*<span>(.*?)<\/span>\s*<\/div>/s', $block)) {
        $unmatched[] = substr($block, 0, 100);
    }
}
print_r($unmatched);
