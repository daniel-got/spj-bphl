<?php
$file = "resources/views/pages/spd/print.blade.php";
$content = file_get_contents($file);
$sheet2Start = strpos($content, '<div class="sheet sheet-2">');

if ($sheet2Start !== false) {
    $sheet1Content = substr($content, 0, $sheet2Start);
    $sheet2Content = substr($content, $sheet2Start);
    
    // Replace 14.4pt with 13.0pt
    $sheet2Content = str_replace('height:14.4pt;', 'height:13.0pt;', $sheet2Content);
    
    $content = $sheet1Content . $sheet2Content;
    file_put_contents($file, $content);
    echo "Replaced 14.4pt successfully.\n";
}
?>
