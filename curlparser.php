<?php
$curl=curl_init();
$//arr['text']="php";
$url='https://php.net/';
  //if( $curl = curl_init() ) {
    curl_setopt($curl, CURLOPT_URL, 'http://www.php.net');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
    $out = curl_exec($curl);
    echo $out;
    curl_close($curl);
  //}