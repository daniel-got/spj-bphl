<?php
$file = "resources/views/pages/spd/print.blade.php";
$content = file_get_contents($file);

$rows = [
    'III' => 1,
    'IV' => 2,
    'V' => 3,
    'VI' => 4,
    'VII' => 5
];

foreach ($rows as $roman => $index) {
    $startStr = ">\n                        $roman.</td>";
    $startPos = strpos($content, $startStr);
    
    if ($startPos === false) continue;
    
    $nextRoman = $roman == 'VII' ? 'VIII' : array_keys($rows)[array_search($roman, array_keys($rows)) + 1];
    $endStr = ">\n                        $nextRoman.</td>";
    $endPos = strpos($content, $endStr, $startPos);
    
    if ($endPos === false) $endPos = strlen($content);
    
    $section = substr($content, $startPos, $endPos - $startPos);
    
    // We need to parse all <tr style="height:8.9pt;"> in this section.
    // The last two <tr> with height:8.9pt are the ones for Name and NIP.
    preg_match_all('/<tr style="height:8.9pt;">(.*?)<\/tr>/s', $section, $matches, PREG_OFFSET_CAPTURE);
    
    // The first 4 matches are tr 5, 6, 7, 8.
    // The last 2 matches are tr 9 (Name) and tr 10 (NIP).
    if (count($matches[0]) >= 6) {
        $tr9 = $matches[0][count($matches[0]) - 2][0];
        $tr10 = $matches[0][count($matches[0]) - 1][0];
        
        // For tr9 (Name): inject into 2nd td, and td after border-right
        $tdCount = 0;
        $newTr9 = preg_replace_callback('/<td(.*?)>(.*?)<\/td>/s', function($tdMatch) use (&$tdCount, $index) {
            $tdCount++;
            if ($tdCount == 2) {
                return '<td' . $tdMatch[1] . '>@if(!empty($spd->destinasi['.$index.']["pejabat_nama"]))<span style="padding-left: 3.5em; text-decoration: underline; "><span class="print-value">{{ $spd->destinasi['.$index.']["pejabat_nama"] }}</span></span>@endif</td>';
            }
            if (strpos($tdMatch[1], 'border-right') !== false) {
                $tdCount = 99; // Next td will be 100
                return $tdMatch[0];
            }
            if ($tdCount == 100) {
                return '<td' . $tdMatch[1] . '>@if(!empty($spd->destinasi['.$index.']["pejabat_nama"]))<span style="padding-left: 3.5em; text-decoration: underline; "><span class="print-value">{{ $spd->destinasi['.$index.']["pejabat_nama"] }}</span></span>@endif</td>';
            }
            return $tdMatch[0];
        }, $tr9);

        // For tr10 (NIP): inject into 2nd td, and td after border-right
        $tdCountNip = 0;
        $newTr10 = preg_replace_callback('/<td(.*?)>(.*?)<\/td>/s', function($tdMatch) use (&$tdCountNip, $index) {
            $tdCountNip++;
            if ($tdCountNip == 2) {
                return '<td' . $tdMatch[1] . '>@if(!empty($spd->destinasi['.$index.']["pejabat_nip"]))<span style="padding-left: 3.5em; "><span class="print-value">NIP. {{ $spd->destinasi['.$index.']["pejabat_nip"] }}</span></span>@endif</td>';
            }
            if (strpos($tdMatch[1], 'border-right') !== false) {
                $tdCountNip = 99; // Next td will be 100
                return $tdMatch[0];
            }
            if ($tdCountNip == 100) {
                return '<td' . $tdMatch[1] . '>@if(!empty($spd->destinasi['.$index.']["pejabat_nip"]))<span style="padding-left: 3.5em; "><span class="print-value">NIP. {{ $spd->destinasi['.$index.']["pejabat_nip"] }}</span></span>@endif</td>';
            }
            return $tdMatch[0];
        }, $tr10);
        
        $newSection = str_replace($tr9, $newTr9, $section);
        $newSection = str_replace($tr10, $newTr10, $newSection);
        
        $content = str_replace($section, $newSection, $content);
    }
}

file_put_contents($file, $content);
echo "Done names and NIPs.\n";
?>
