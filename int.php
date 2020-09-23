<?php
function validation($value,$start,$leght){
$value=trim($value);
$value=rtrim($value);
$value=substr($value,$start,$leght);
return $value;
}
function imgLoad($url,$nm){
    $ch = curl_init($url);  
    curl_setopt($ch, CURLOPT_HEADER, 0);  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
    curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);  
    $out = curl_exec($ch);  
    $image_sv ='./images/'.$nm.'.png';  
    $img_sc = file_put_contents($image_sv, $out);  
    curl_close($ch);  
}

function validationTime($value,$charStart='',$charStop=''){
   $time=trim($value);
      $time=str_replace($charStart,$charStop,$time);
         if(mb_strpos($time,'СЕГОДНЯ')!==false){
           $time=date('Y-m-d');
         }
         else{
           $date=new DateTime($time);
           $time=$date->format('Y-m-d');
         }
  return $time;
}

function connects($host,$user,$passwd,$bd){
   $link=mysqli_connect($host,$user,$passwd,$bd) or die(mysql_error());
   mysqli_set_charset($link,"utf8");
return $link; 
}

function clear($val){
   $value=htmlspecialchars(strip_tags($val));
return $value;
}

function Bdlog($object,$time,$ping,$job){
   $link=connects('localhost','serj','22121987','cscart');
   $sql="INSERT INTO `time` (`Object`, `time`, `ping`, `job`) VALUES
    ('$object', '$time', '$ping', '$job')";
   mysqli_query($link,$sql);
   }
function staticPower($status,$time){
    $link=connects('localhost','serj','22121987','cscart');
    $start=date("Y-m-d");
    $start=$start.' 00:00:00';
    $array=mysqli_query($link,"Select * from `time` where `time` Between $start  and $time ");
return $array;
}  


function product($src,$product,$code,$brend,$url,$price,$date){
   $link=connects('localhost','serj','22121987','cscart');
   $sql="INSERT INTO `product` (`id`,`src`, `product`, `code`, `brendmarket`,`url`, `price`, `date` ) VALUES (NULL,'$src', '$product', '$code', '$brend','$url','$price','$date')";
   mysqli_query($link,$sql);
   }

function parsePrice($value){
  if($lenght=stripos($value,'рублей')){
     $result=substr($value,0,$lenght);
     $result=preg_replace("/[^0-9]/i", '', $result); 
     $array=array('number'=>$result,'mer'=>'rub');
   }
  elseif ($lenght=strpos($value,'%')){
    $result=substr($value,$lenght-2,2);

    $result=rtrim($result);
    if($result=='!'){
          $result=substr($value,$lenght-1,1);
      }
      $array=array('number'=>$result,'mer'=>'%');
   }
    else{
       $array=array('number'=>0,'mer'=>'-');
    }
    
return $array;
}

function cronDel(){
   $link=connects('localhost','serj','22121987','cscart');
   $countQuery="select `product` from `product` where `date`=DATE_ADD(CURDATE(), INTERVAL -1 DAY)";
   $result=mysqli_query($link,$countQuery) or die("Ошибка". mysqli_error());
   if($result=mysqli_num_rows($result)>0){
      $sql="DELETE FROM `product` WHERE `product`.`date` = DATE_ADD(CURDATE(), INTERVAL -1 DAY)";
      mysqli_query($link,$sql) or die("Ошибка". mysqli_error());
        return 'Удаленно '.$result." записей";
   }
   else{
      return 'Отчистка не нужна';
   }
 }
function validationMarket($value){
   $value=trim($value);
   $english=mb_ereg_replace("/[а-яёА-ЯЁ0-9]/i", '', $value);
   $result=mb_ereg_replace("/(.*?)\{.*?\}\s?(.*?)/is", '', $english);
   (string)$result=rtrim($english);
   $lenght=mb_strlen($result);
   if($lenght<2){
      $russian=mb_ereg_replace("/[a-zA-Z0-9]/i", '', $value);
      $result=mb_ereg_replace("/(.*?)\{.*?\}\s?(.*?)/is", '', $russian); 
    }
  return $result;
}
function postIp($url,$domen='false'){
      $char=strrchr($url,'/');
       $url=preg_replace('|[/]|','',$char);
      if($domen==='ru'){
          $ip=gethostbyname ('www.'.$url.'.ru');
      }
      else{
         $ip=gethostbyname ('www.'.$url);
      }
      $ip=preg_replace('/[a-z]/i','',$ip);
      $lenght=strlen($ip);
       if(7<$lenght && $lenght<17){
         //return $lenght.'/';
         $ip='bad ip';
      }
      //else
       if(preg_match('/^www/',$ip)==true || empty($ip)){
          $ip='bad ip';
      }
      else{
        //return $ip;
      }
      return $ip;
}
   ?>