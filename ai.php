<?php
function ai($img){
  // 1. Send image to Cloud OCR SDK using processImage call
  // 2.	Get response as xml
  // 3.	Read taskId from xml
  // https://ocrsdk.com/documentation/faq/#faq3
  // Name of application you created
  $applicationId = '24d8dcc8-645c-45c2-ac28-62d6dcbb19fb';
  // Password should be sent to your e-mail after application was created
  $password = 'sk49J6Q11kaaAkZsdz6VEaN7';
  
  // URL of the processing service. Change to http://cloud-westus.ocrsdk.com
  $serviceUrl = 'http://cloud-eu.ocrsdk.com';
  // Get path to file that we are going to recognize
  $local_directory=dirname(__FILE__).'/images/';
  $filePath = $local_directory.$img.".png";
  if(!file_exists($filePath))
  {
    die('File '.$filePath.' нет.');
  }
  if(!is_readable($filePath) )
  {
     die('Доступ к '.$filePath.' запрещен.');
  }
  // Recognizing with English language to rtf
  // You can use combination of languages like ?language=english,russian or
  // ?language=english,french,dutch
  // For details, see API reference for processImage method
  $url = $serviceUrl.'/processImage?language=russian,english&exportFormat=txt';
  // Send HTTP POST request and ret xml response
  $curlHandle = curl_init();
  curl_setopt($curlHandle, CURLOPT_URL, $url);
  curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($curlHandle, CURLOPT_USERPWD, "$applicationId:$password");
  curl_setopt($curlHandle, CURLOPT_POST, 1);
  curl_setopt($curlHandle, CURLOPT_USERAGENT, "PHP Cloud OCR SDK Sample");
  curl_setopt($curlHandle, CURLOPT_FAILONERROR, true);
  $post_array = array();
  if((version_compare(PHP_VERSION, '5.5') >= 0)) {
    $post_array["my_file"] = new CURLFile($filePath);
  } else {
    $post_array["my_file"] = "@".$filePath;
  }
  curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $post_array); 
  $response = curl_exec($curlHandle);
  if($response == FALSE) {
    $errorText = curl_error($curlHandle);
    curl_close($curlHandle);
    die($errorText);
  }
  $httpCode = curl_getinfo($curlHandle, CURLINFO_HTTP_CODE);
  curl_close($curlHandle);
  // Parse xml ответ
  $xml = simplexml_load_string($response);
  if($httpCode != 200) {
    if(property_exists($xml, "message")) {
       die($xml->message);
    }
    die(" Некоректный ответ-".$response);
  }
  $arr = $xml->task[0]->attributes();
  $taskStatus = $arr["status"];
  if($taskStatus != "Queued") {
    die("Неожиданный статус задачи ".$taskStatus);
  }
  $taskid = $arr["id"];  
  // 4. Get task information in a loop until task processing finishes
  // 5. If response contains "Completed" staus - extract url with result
  // 6. Download recognition result (text) and display it
  $url = $serviceUrl.'/getTaskStatus';
  if(empty($taskid) || (strpos($taskid, "00000000-0") !== false)) {
    die("Индентификатор не \зарегестрирован");
  }
  $qry_str = "?taskid=$taskid";
  // Check task status in a loop until it is finished
  // Note: it's recommended that your application waits
  // at least 2 seconds before making the first getTaskStatus request
  // and also between such requests for the same task.
  // Making requests more often will not improve your application performance.
  // Note: if your application queues several files and waits for them
  // it's recommended that you use listFinishedTasks instead (which is described
  // at https://ocrsdk.com/documentation/apireference/listFinishedTasks/).
  while(true)
  {
    sleep(5);
    $curlHandle = curl_init();
    curl_setopt($curlHandle, CURLOPT_URL, $url.$qry_str);
    curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curlHandle, CURLOPT_USERPWD, "$applicationId:$password");
    curl_setopt($curlHandle, CURLOPT_USERAGENT, "PHP Cloud OCR SDK Sample");
    curl_setopt($curlHandle, CURLOPT_FAILONERROR, true);
    $response = curl_exec($curlHandle);
    $httpCode = curl_getinfo($curlHandle, CURLINFO_HTTP_CODE);
    curl_close($curlHandle);
    // parse xml
    $xml = simplexml_load_string($response);
    if($httpCode != 200) {
      if(property_exists($xml, "message")) {
        die($xml->message);
      }
      die("Некоректный ответ - ".$response);
    }
    $arr = $xml->task[0]->attributes();
    $taskStatus = $arr["status"];
    if($taskStatus == "Queued" || $taskStatus == "InProgress") {
      // Ждем
      continue;
    }
    if($taskStatus == "Completed") {
      // Выйти из цикла и продолжить обработку
      break;
    }
    if($taskStatus == "ProcessingFailed") {
      die("Ошибка обработки ответа: ".$arr["error"]);
    }
    die("Статус ".$taskStatus);
  }
 // Загрузка результата
  $url = $arr["resultUrl"];   
  $curlHandle = curl_init();
  curl_setopt($curlHandle, CURLOPT_URL, $url);
  curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, false);
  $response = curl_exec($curlHandle);
  curl_close($curlHandle);
  return $response;
}

?>