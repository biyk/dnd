# dnd

#TODO
голосовые команды на запуск картинок
бутстраповский шаблон панели
голосовые команды на разработку\отладку
голосовые команды на поиск заклинаний\монстров
голосовой отклик

Карты-проекты - у каждой карты свой набор конфигов\команд

<?php

$url = "https://dnd.su/request/live_search/bestiary/classic/";

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$headers = array(
   "Content-Type: text/plain;charset=UTF-8",
);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

$data = '{"search":"uj,kby"}';

curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($curl);
curl_close($curl);
var_dump($resp);

?>

