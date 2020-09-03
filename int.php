<?php
function validation($value,$start,$leght){
$value=trim($value);
$value=rtrim($value);
$value=substr($value,$start,$leght);
return $value;
}
function validationTime($value,$charStart='',$charStop=''){
  // if($charStart==='' || $charStop===''){
  //    $time=date('Y-m-d');
 //  }
  // else{
      $time=trim($value);
      $time=str_replace($charStart,$charStop,$time);
         if(mb_strpos($time,'СЕГОДНЯ')!==false){
           $time=date('Y-m-d');
         }
         else{
           $date=new DateTime($time);
           $time=$date->format('Y-m-d');
         }
  // }
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
//unction cronCount(){
   //$link=connects('localhost','serj','22121987','cscart');
   //$sql="select  FROM `product` WHERE `product`.`date` = DATE_ADD(CURDATE(),INTERVAL -1 DAY)";
   //$sql="select count(`product`.`date`) from `product` where `date`=DATE_ADD(CURDATE(), INTERVAL -1 DAY)";
  // $result=mysqli_query($link,$sql);
   //return $result; 
//}
   ?>