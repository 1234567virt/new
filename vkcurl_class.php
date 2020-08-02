<?php
//function status($username,$host){
 // $username='admin';
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
    //    return $htm;
     // }?>