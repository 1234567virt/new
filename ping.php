<?php
$massiv=file('/home/serj/ip.txt');
$out=exec('ping -c 10 192.168.1.1');
var_dump($out);
//foreach($massiv as $key=>$val){
    //echo `ls -al`;
//}
//?>