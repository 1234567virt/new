<link rel='stylesheet' type="text/css" href="vkcurl.css">
<?php
 //$password='12LinuX21';
$username='admin';
$host=array('Офис'=>['ip'=>'http://192.168.1.161',
    'auth'=>'true',
    'port'=>80,
    'password'=>'12LinuX21'
],
'Xyi-vai'=>['ip'=>'http://213.87.9.3',
    'auth'=>'true',
    'port'=>81,
    'password'=>'admin'
],
'Веерская'=>[
    'ip'=>'http://31.173.23.45',
    'auth'=>'true',
    'port'=>8080,
    'password'=>'12LinuX21'
]
);

foreach($host as $key=>$host){
    require_once 'vkcurl_class.php';    
    if($htm[1]=='200')
    {
    ?>
<div id='table_on'>
    <h3><?=$key ?></h3><span class='jobs'>Работает:</span><span class='time'><?=date("Y-m-d H:i:s")?><br>
        <span class='jobs'>Время доступа:</span><?=$sec ?><br>
</div>
<?php
}
else 
{
?>
<div id='table_of'>
    <h3><?=$key?></h3><span class='bich'>Неработает</span class='time'>:<?=date("Y-m-d H:i:s");?></span>
</div>
<?php
}

}

?>