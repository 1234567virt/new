<?php
require_once 'phpQuery.php';
function parser($array,$name,$src,$code,$brend,$price){
 // $array=phpQuery::newDocument($result);
  $content=$array->find('article');

  foreach($content as $key=>$val)
    {
      $value= pq($val);
      $name=$value->find($name)->attr('alt');
      $src=$value->find($src)->attr('src');
      $code=$value->find($code)->attr('value');
      $brend=$value->find($brend)->text();
      $price=$value->find($price)->text();
//$url=$src->text();
      if(!empty($name) && !empty($code)){
        $array= $i."/<h3 style='display:inline;'>".$name."</h3>-<i>".$price."</i>/<b>".$code."/</b>".validation($brend,'.')."/".$src."/<br>";

      }
 
    }
return $array;
}
function validation($value,$char){
$value=trim($value);
$value=rtrim($value);
//$value=strip_tags($value);
//S$value=substr($value,strpos($value,$char),-1);
return $value;
}
?>