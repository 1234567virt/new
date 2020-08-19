<html>

<head>
    <meta http-equiv="Refresh" content='1000'>
    <link href="css.css" rel="stylesheet" type="text/css" />

</head>

<body>
    <?php
require_once 'phpQuery.php';
require_once 'int.php';


set_time_limit(0);

for($i=1;$i<100;$i++)
{
   $addr="http://www.pepper.ru/new/?page=".$i."&ajax=true&layout=horizontal";
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
      $content=$array->find('article');
    foreach($content as $key=>$val)
    {
      $value= pq($val);
      $name=$value->find(".thread-image")->attr('alt');
      $src=$value->find(".cept-thread-img")->attr('src');
       $time=$value->find(".hide--toW3 span")->text(); 
      if(empty($src) && empty($time)){
          unset($src);
          $src=$value->find(".img--dummy--loaded")->attr('src');
          $time=validationTime('0000-00-00','-','/');
      }
      else{
          $time=validationTime($time,'/','-');
      }
       
      $code=$value->find("input")->attr('value');
      $brend=$value->find(".link")->text();
      $price=$value->find("span .thread-price")->text();
      $price=validation($price,0,-3);
      //$price=parsePrice()
      if(!empty($name) && !empty($code)){
        echo $i."/<h3 style='display:inline;'>".$name."</h3>-<span>".$price."</span><b> ".$code."/</b>"."/".$src."-".$time."<br>";
       product($src,$name,$code,$brend,$price,$time);
      }
    }

}

?>
</body>

</html>