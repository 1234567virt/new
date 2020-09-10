<html>

<body>
    <?php
require_once 'phpQuery.php';
require_once 'int.php';
set_time_limit(0);
for($i=1;$i<30;$i++)
{
  $addr="https://www.pepper.ru/new"."?page=".$i."&layout=text";
  //$addr=$addr."?page=".$i."&layout=text";
  echo "<h3 style='margin-top:15px;margin-bottom:10px;margin-left:50%;'>json.".$i."-".$addr."</h3>";
  $curl = curl_init();
    curl_setopt($curl,CURLOPT_URL,$addr);
    curl_setopt ($curl, CURLOPT_USERAGENT , "Mozilla/5.0 (Windows; U; Windows NT 5.1; ru-RU; rv:1.7.12) Gecko/20050919 Firefox/1.0.7");
    curl_setopt($curl,CURLOPT_HEADER,0);
    curl_setopt($curl, CURLOPT_FAILONERROR, true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($curl);
  //$result=file_get_contents($addr);
  $array=phpQuery::newDocument($result);
  $content=$array->find('article');
    foreach($content as $key=>$val)
    {
      $value= pq($val);
      $name=$value->find(".thread-image")->attr('alt');
      $img=$value->find('img')->attr('src');
      $time=$value->find(".hide--toW3 span")->text();
       $code=$value->find("input")->attr('value');
      $brend=$value->find(".link")->text();
      $price=$value->find("span .thread-price")->text();
      $price=validation($price,0,-3);
      if(!empty($name) && !empty($code)){
          if(empty($time)){
              $time=date('Y-m-d');
          }
          else{
              $time=validationTime($time,'/','.');
          }
        (int)$price=str_replace(' ', '',$price);
         echo $i.".".$key."/<h3 style='display:inline;'>".$name."</h3>-<span>".$price."</span><b> ".$code."/</b>"."/".$time." <i style='color:green'>Код найден</i><br>";
         product($img,$name,$code,$brend,$price,$time);
      }
      else{
        echo $i.".".$key.'/fack- '.$name."/".$code."<span style='color:red;border:1px solid black'>Нет кода</span><br>";
      }
   
    }
}
?>
</body>

</html>