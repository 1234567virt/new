<link rel="stylesheet" type="text/css" href="ps.css">

<?php
require_once 'phpQuery.php';
require_once 'ps_class.php';
$url="http://www.php.su/";
$command='substr()';
    $curl = curl_init();
    curl_setopt($curl,CURLOPT_URL,$url.$command);
    curl_setopt($curl,CURLOPT_HEADER,0);
    curl_setopt($curl,CURLOPT_NOBODY,0);
    curl_setopt($curl, CURLOPT_FAILONERROR, true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($curl);
    curl_close($curl);
    
    $isWinCharset = mb_check_encoding($result, "windows-1251");
    if ($isWinCharset) {
        $result = iconv("windows-1251", "UTF-8", $result);
    }
    $contents=findFunct($result,'<index>','</index>');
?>
<div class='body'>
    <?=$contents;?>
</div>