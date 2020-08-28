<?php
$url = 'img.png';
$data = json_decode(file_get_contents('http://api.rest7.com/v1/ocr.php?url=' . $url . '&format=txt'));

if (@$data->success !== 1)
{
die('Failed');
}
$txt = file_get_contents($data->file);
file_put_contents('text.txt', $txt);