<?php

$apiKey = file_get_contents("apikey.txt");

$curl = curl_init();
$text = htmlspecialchars($_GET['place']); #искомое место
$text = rawurlencode($text); #Теперь переводим текст искомого места в 
#адрес, по которому делаем запрос
$addr = sprintf("https://geocode-maps.yandex.ru/1.x?geocode=%s&apikey=%s&format=json", $text, $apiKey);

#задаём параметры запроса
curl_setopt_array($curl, [
  CURLOPT_URL => $addr,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
]);

$response = curl_exec($curl); #выполняем запрос
curl_close($curl); #Завершаем сеанс cURL и освобождаем все ресурсы

$response = json_decode($response, true); #декодируем ответ в json

#находим координаты. Превращаем строку в массив из двух элементов.
$position = explode(" ", $response["response"]["GeoObjectCollection"]["featureMember"][0]["GeoObject"]["Point"]["pos"]);
#если координаты пусты, то возвращаем ошибку и умираем
if ( empty($position[0]) )
{
  echo "По вашему запросу не удалось ничего найти";
  die();
}

printf("Координаты: %s<br>", $position[1] . "," . $position[0]); #вывод координат в привычном формате
printf("Полный адрес: %s<br>", $response["response"]["GeoObjectCollection"]["featureMember"][0]["GeoObject"]["metaDataProperty"]["GeocoderMetaData"]["Address"]["formatted"]); #вывод полного адреса

$curl = curl_init(); 

$coords = $position[0] . "," . $position[1]; #записываем координаты в формате, который принимает api
#генерируем адрес запроса
$addr = sprintf("https://geocode-maps.yandex.ru/1.x/?apikey=%s&geocode=%s&kind=metro&format=json&results=1", $apiKey, $coords);
#задаём параметры запроса
curl_setopt_array($curl, [
  CURLOPT_URL => $addr,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
]);

$response = curl_exec($curl); #выполняем запрос
curl_close($curl); #Завершаем сеанс cURL и освобождаем все ресурсы

$response = json_decode($response, true); #декодируем ответ в json

#Если не нашло метро, то возвращаем ошибку
if( $response["response"]["GeoObjectCollection"]["featureMember"][0]["GeoObject"]["name"] == "")
{
  echo "Не удалось найти метро поблизости.";
}
else
{
  printf( "Ближайшее метро: %s", $response["response"]["GeoObjectCollection"]["featureMember"][0]["GeoObject"]["name"]);
}
