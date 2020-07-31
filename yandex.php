<?php
$curl=curl_init();
$arr['text']="php";
$url='https://yandex.ru/search/';
curl_setopt($curl,CURLOPT_URL,$url);
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
curl_setopt($curl,CURLOPT_POSTFIELDS,'text=php');
$output=curl_exec($curl);
curl_close($curl);
echo $output;
?>