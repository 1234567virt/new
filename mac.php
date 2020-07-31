<?php
set_time_limit(0);
require_once 'phpQuery.php';
require_once 'sing_class.php';
?>
<html>
<link rel='stylesheet' type="text/css" href="style_singless.css">

<body>
    <table>
        <tr>
            <th>Песня</th>
            <th>Статус</th>
            <th>Директория</th>
            <th>Размер</th>
        </tr>
        <?php
$text=file_get_contents('https://ruq.hotmo.org/collection/2794');
$array=phpQuery::newDocument($text);
$content=$array->find('a.track__download-btn');

foreach($content as $key=>$val){
    $value = pq($val);
    $url= $value->attr('href');
    $name_sings=translit($url);
    $file=__DIR__.'/sing/'.$name_sings.'.mp3';
?>
        <tr>
            <td id='name'><?=$name_sings; ?></td>
            <?php
    if (file_exists($file)) {
      $time=info_file($file);
?>
            <td><span id class='err'>Cуществует</span></td>
            <?php
      }
      else 
      {
?>

            <?php
      upload_sing($url,$name_sings);
      $time=info_file($file);
?>

            <td><span id class='ok'>Закачен</span></td>
            <?php
      }
?>

            <td class='dir'><?=__DIR__.'/sing/'; ?></td>
            <td class='size'><?=$time[1]." Мб"; ?></td>
        </tr>
        <?php
  }
?>
    </table>
</body>

</html>