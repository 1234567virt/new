<?php
$ip='http://213.87.9.3:81';


        $ch=curl_init();
        curl_setopt($ch,CURLOPT_URL,$ip);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $html=curl_exec($ch);
        $htm=explode(" ",$html);
        curl_close($ch);
        var_dump($htm);
?>