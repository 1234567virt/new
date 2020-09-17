<?php
set_time_limit(0);
require_once 'phpQuery.php';
require_once 'int.php';
require_once 'ai.php';
$addr="https://promokod.pikabu.ru/new";

$curl = curl_init();
    curl_setopt($curl,CURLOPT_URL,$addr);
    curl_setopt ($curl, CURLOPT_USERAGENT , "Mozilla/5.0 (Windows; U; Windows NT 5.1; ru-RU; rv:1.7.12) Gecko/20050919 Firefox/1.0.7");
    curl_setopt($curl,CURLOPT_HEADER,0);
    curl_setopt($curl, CURLOPT_FAILONERROR, true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($curl);
    curl_close($curl);
    $array=phpQuery::newDocument($result);
    $content=$array->find('.item-tovars');
    foreach($content as $key=>$product){
        $item=pq($product);
        $product=$item->find(".click-coupon")->text();
        $img=$item->find('img')->attr('src');
        $code=$item->find(".open-coupon ")->attr('data-code');
        $time=$item->find(".data")->text();
        $time=substr($time,-10);
        $time=validationTime($time,'.','.');
        $price=parsePrice($product);
        if(!empty($code)){
             imgLoad($img,$key);
           
             $market=ai($key);
             $market=validationMarket($market);
             echo $key."/<i>".$product."</i>-<b>".$code."</b><i>.".$price['number'].$price['mer']."/</i>".$time."/".$market."<br>";
             product($price['mer'],$product,$code,$market,$price['number'],$time);
 
         }
       }

?>