<?php
function findFunct($result,$start,$stop){
    $content=substr($result,stripos($result,$start));
    $stop=stripos($content,$stop);
    $content=substr_replace($content,'',$stop);
return $content;
}
?>