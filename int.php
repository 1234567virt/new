<?php
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
   ?>