<link rel='stylesheet' type="text/css" href="vkcurl.css">

<head>
    <meta http-equiv="Refresh" content='1000'>
</head>
<?php
require_once 'int.php';
$username='admin';
$host=array('Офис'=>[
    'ip'=>'http://192.168.1.161',
    'auth'=>'true',
    'port'=>80,
    'password'=>'12LinuX21'
],
'Xyi-vai'=>[
    'ip'=>'http://213.87.9.3',
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
  // require_once 'vkcurl_class.php';
    $ch=curl_init();
        curl_setopt($ch, CURLOPT_PORT, $host['port']);
        if($host['auth']==true)
        {
            curl_setopt($ch,CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_USERPWD, $username.":".$host['password']);
        }
        curl_setopt($ch,CURLOPT_URL,$host['ip'].":".$host['port']);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_NOBODY,true);
        curl_setopt($ch,CURLOPT_HEADER,true);
        $html=curl_exec($ch);
        $sec=curl_getinfo($ch,CURLINFO_STARTTRANSFER_TIME);
        $htm=explode(" ",$html);
        curl_close($ch);
   if(isset($htm[1]) && $htm[1]=='200')
    {
 ?>
<div id='table_on'>
    <h3><?=$key; ?></h3><span class='jobs'>Работает:</span><span class='time'><?=date("Y-m-d H:i:s")?><br>
        <span class='jobs'>Время доступа:</span><?=$sec ?><br>
</div>
<?php
$time=date("Y-m-d H:i:s");
Bdlog($key,$time,$sec,1);
}
else 
{
?>
<div id='table_of'>
    <h3><?=$key; ?></h3><span class='bich'>Неработает</span class='time'>:<?=date("Y-m-d H:i:s");?></span>
</div>
<?php
   $time=date("Y-m-d H:i:s");
    Bdlog($key,$time,$sec,0);
}

}
$array=staticPower('1',$time);
var_dump($array);
foreach($array as $key=>$val){
    echo $val['Object']."->".$val['ping']."<br>";
}
?>