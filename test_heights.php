<?php
$content = file_get_contents("resources/views/pages/spd/print.blade.php");
$sheet2Start = strpos($content, '<div class="sheet sheet-2">');
$sheet2Content = substr($content, $sheet2Start);

echo "Count 8.9pt: " . substr_count($sheet2Content, 'height:8.9pt;') . "\n";
echo "Count 14.4pt: " . substr_count($sheet2Content, 'height:14.4pt;') . "\n";
?>
