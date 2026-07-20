<?php
$file = 'resources/views/pages/spd/print.blade.php';
$content = file_get_contents($file);

// Replace CSS
$cssOld = <<<CSS
        .labelrow {
            display: block;
            width: 100%;
            overflow: hidden;
        }

        .labelrow span:first-child {
            display: block;
            float: left;
            width: 75pt;
        }

        .labelrow span:last-child {
            display: block;
            margin-left: 75pt;
        }
CSS;

$cssNew = <<<CSS
        .labelrow-table {
            width: 100%;
            border-collapse: collapse;
            border: none !important;
            margin: 0;
            padding: 0;
        }
        .labelrow-table td {
            border: none !important;
            padding: 0 !important;
            vertical-align: top;
            text-align: left;
        }
        .labelrow-table .label-col {
            width: 75pt;
        }
CSS;

$content = str_replace($cssOld, $cssNew, $content);

// Replace HTML
$pattern = '/<div class="labelrow">\s*<span>(.*?)<\/span>\s*<span>(.*?)<\/span>\s*<\/div>/s';
$replacement = '<table class="labelrow-table"><tr><td class="label-col">$1</td><td class="value-col">$2</td></tr></table>';
$content = preg_replace($pattern, $replacement, $content);

file_put_contents($file, $content);
echo "Fixed!\n";
