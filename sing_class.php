    <?php
function upload_sing($url,$key){
    $single=__DIR__.'/sing/'.$key.'.mp3';
    $sings=file_get_contents($url);
    $fp=fopen($single,"w+");
    fwrite($fp,$sings);
    fclose($fp); 
}

function info_file($file){
   $mb=filesize($file)/1048576;
   $array[]=$file;
   $array[]=number_format($mb,2);
   return  $array;
}
function translit($text){
  $start= strpos($text,'muzlome');
   $singl=substr($text,$start+8,-4);
   $name = preg_replace('/\d/', '', $singl); 
return $name;
}

function connects($host,$user,$passwd,$bd){
   $link=mysqli_connect($host,$user,$passwd,$bd) or die(mysql_error());
    return $link; 
    }
 
?>