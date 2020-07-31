<?php
$url="http://www.php.su/echo()";
//function=substr;
       $curl = curl_init();
       curl_setopt($curl,CURLOPT_URL,$url);
       curl_setopt($curl,CURLOPT_HEADER,0);
       curl_setopt($curl,CURLOPT_NOBODY,0);
       //curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; ru-RU; rv:1.9.1.2) Gecko/20090729 Firefox/3.5.2 GTB5');
       curl_setopt($curl, CURLOPT_FAILONERROR, true);
       curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
       curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
       $result = curl_exec($curl);
       curl_close($curl);
       
echo $result;
?>