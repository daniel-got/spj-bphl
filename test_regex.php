<?php
$content = file_get_contents('resources/views/pages/spd/print.blade.php');
$pattern = '/<div class="labelrow">\s*<span>(.*?)<\/span>\s*<span>(.*?)<\/span>\s*<\/div>/s';
preg_match_all($pattern, $content, $matches);
echo "Matched: " . count($matches[0]) . "\n";
