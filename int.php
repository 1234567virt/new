<?php
function validation($value,$start,$leght){
$value=trim($value);
$value=rtrim($value);
$value=substr($value,$start,$leght);
return $value;
}
function validationTime($value,$charStart='',$charStop=''){
   if($charStart==='' || $charStop===''){
      $time=date('Y-m-d');
   }
   else{
      $time=trim($value);
      $time=str_replace($charStart,$charStop,$time);
         if(mb_strpos($time,'СЕГОДНЯ')!==false){
           $time=date('Y-m-d');
         }
         else{
           $date=new DateTime($time);
           $time=$date->format('Y-m-d');
         }
   }
  return $time;
}

function connects($host,$user,$passwd,$bd){
   $link=mysqli_connect($host,$user,$passwd,$bd) or die(mysql_error());
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
   // while($row=mysqli_fetch_assoc($result)){
    //$array=$row;
  // }
    return $array;
}  


function product($src,$product,$code,$brend,$price,$date){

   $link=connects('localhost','serj','22121987','cscart');

   $sql="INSERT INTO `product` (`id`,`src`, `product`, `code`, `brendmarket`, `price`, `date` ) VALUES (NULL,'$src', '$product', '$code', '$brend','$price','$date')";
  // echo $sql;
   mysqli_query($link,$sql);
   }

function parsePrice($value){
  if($lenght=stripos($value,'рублей')){
     $result=substr($value,0,$lenght);
     $result=preg_replace("/[^0-9]/i", ' ', $result); 
    }
  elseif ($lenght=strpos($value,'%')){
     //$len=$lenght-2;
   $result=substr($value,$lenght-2,3);
   $result=rtrim($result);
    }
    else{
       $result='0';
    }
return $result;
}

function (){}
   ?>