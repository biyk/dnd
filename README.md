## TODO
- возможность двигать и масштаб картинки
- dnd картинок
- Добавить канвасы в конфиги
- перенести генераторы в гугл таблицы
- Таб с генераторами Из бездны
- таб с генераторами TODO проверить локации
- Здоровье мобов\героев
- зоны действия магии
- иконки для инициативы
- поле для редактирования названия картинки чтобы добавить в демо new URL($('.test')[0].src)
- Таб с текущим монстром

убрать\архив лишние скрипты\стили\страницы

голосовые команды на разработку\отладку
голосовые команды на поиск заклинаний\монстров
голосовой отклик
Карты-проекты - у каждой карты свой набор конфигов\команд
свет/тень

https://bestprogrammer.ru/izuchenie/rukovodstvo-po-integratsii-api-google-tablits-v4
https://developers.google.com/sheets/api/quickstart/js?hl=en#create_an_api_key
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

https://skybox.blockadelabs.com/f62612f424ea2d03d4f373e3d5e8cdef
https://skybox.blockadelabs.com/4a1396a364324a342322a0106eea7945
https://skybox.blockadelabs.com/82080e130ef3975832e4ce1724b5cbaf
https://skybox.blockadelabs.com/09997cc91f3d61522fc62dd5323b3b01




