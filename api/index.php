<?php

/**
 * Обработка поступающих голосовых команд и выдача команд для
 */

include '../utils/func.php';
date_default_timezone_set('Europe/Ulyanovsk');
$type = $_REQUEST['type'];
$locales = empty($_REQUEST['text'])?[]:explode(' ', $_REQUEST['text']);
 // Initialize the config array
$config = [];

$path = '../json/videos.json';
 // Get the contents of the videos.json file and decode the JSON into an array
$json_v = json_decode(file_get_contents($path), 1);

$json_command = json_decode(file_get_contents('../json/commands.json'), 1);
$image_command = json_decode(file_get_contents('../json/images.json'), 1);
$map = getSettings('map');
$json_map = json_decode(file_get_contents('../json/'.$map.'/map.json'), 1);
if ($type=='locale'){
     // Loop through each phrase and command in the commands.json file
   	foreach ($json_command as $phrase=>$command){
       // If the phrase is found in the locales parameter
       if (strpos($_REQUEST['text'],$phrase)!==false) {
           $config['command'] = selectCommand(compact(['phrase', 'command', 'locales']));
       }
    }

   	foreach ($image_command as $phrase=>$image){
   	    if (strpos($_REQUEST['text'],$phrase)!==false) {
		   $config['command'] = "loadDemo('".$image."');";
	   }
    }
	// для каждого слова из команды
	foreach ($locales as $locale) {
 		// Loop through each video name and URL in the json_v array
		foreach ($json_v as $video=>$name){
            // If the locale is found in the video name, set the locale in the config array
            if (in_array($locale, explode(' ',$name)))
				$config['locale'] = $video;
        }
    }
}

if ($type=='map'){
	$json_map[$_REQUEST['chunk']] = $_REQUEST['checked'];
    $map = getSettings('map');
	file_put_contents('../json/'.$map.'/map.json', json_encode($json_map,JSON_PRETTY_PRINT));
}

if ($type=='demo'){
    $image = $_REQUEST['src'];
    $config['command'] = "loadDemo('".$image."');";
}

if ($type=='videos'){
    $new_videos = $_REQUEST['videos'];
    var_dump($new_videos);
    foreach ($new_videos as $video=>$key){
        if ($key) $json_v[$video] = $key;
        else unset($json_v[$video]);
    }
    file_put_contents('../json/videos.json', json_encode($json_v,JSON_PRETTY_PRINT));
}


if ($type=='init'){
    $init = $_REQUEST['init'];
    var_dump($init);
    $map = getSettings('map');
    saveJson('../json/'.$map.'/init.json', $init);
}

if ($type=='time'){
    // Загружаем данные из файла time.json
    $map = getSettings('map');
    $data = file_get_contents("/json/$map/time.json");
    $timeData = json_decode($data, true);
    //pre($timeData);
    // Получаем текущую метку времени из файла
    $currentTime = $timeData['time'];

    // Получаем переданные значения времени и единицы времени
    $time = $_REQUEST["time"];
    $timeUnit = $_REQUEST["unit"] ?? '';

    // Преобразуем дни и минуты в часы, если необходимо
    if ($timeUnit === "minutes") {
        $time /= 60;
    } elseif ($timeUnit === "days") {
        $time *= 24;
    }

    //$time время в часах

    // Рассчитываем сколько времени нужно до ближайшего часа и вычитаем из общей суммы добавленных часов
    $minutesToAdd = 60 - date('i' ,$currentTime-62167230732);
    $eventTypes = [];

    // Если сумма добавляемых часов меньше, просто добавляем минуты к текущей метке времени
    if ($time*60 < $minutesToAdd) {
        $currentTime += $time * 3600;
    } else {
        // Добавляем остатки до ближайшего часа к итоговому времени
        $currentTime +=  $minutesToAdd * 60;
        //pre(date("Y-m-d H:i:s", $currentTime-62167230732));
        $time-=$minutesToAdd/60;
        // Иначе, в цикле добавляем по одному часу и вычитаем его из общей суммы, пока целые часы не закончатся
        while ($time >= 0) {
            // Вычисляем количество и типы событий, произошедших между старой и новой метками времени
            if (isset($timeData['events']['h'])) {
                $hourlyEvents = $timeData['events']['h'];
                foreach ($hourlyEvents as $event) {
                    $eventTypes[$event] = isset($eventTypes[$event]) ? $eventTypes[$event] + 1 : 1;
                }
            }

            if (date("H", $currentTime-62167230732)==7 && isset($timeData['events']['d'])) {
                $hourlyEvents = $timeData['events']['d'];
                foreach ($hourlyEvents as $event) {
                    $eventTypes[$event] = isset($eventTypes[$event]) ? $eventTypes[$event] + 1 : 1;
                }
            }

            // Добавляем час к текущей метке времени
            $currentTime += 3600;
            $time--;
        }

        // Добавляем остатки до ближайшего часа к итоговому времени
        $currentTime += $time * 3600;
    }

    // Вычисляем количество и типы событий
    $eventCount = array_sum($eventTypes);

    // Формируем результат в виде массива
    $result = [
        "currentDateTime" => date("d д m м Y л H:i:s", $currentTime-62167230732),
        "eventCount" => $eventCount,
        "eventTypes" => $eventTypes
    ];
    // Возвращаем результат в формате JSON

    if($timeData['time'] != $currentTime){
        $timeData['time'] = $currentTime;
        $map = getSettings('map');
        saveJson('/json/'.$map.'/time.json', $timeData);
    }

    echo json_encode($result);
    header("Content-type:application/json");
    die();
}

if ($type=='map_position'){
    $map = getSettings('map');
    saveJson('/json/'.$map.'/map_position.json', $_REQUEST);
}

if ($type=='settings'){
    $settings = getSettings();
    foreach ($settings as $key=>$val){
        if ($_REQUEST[$key]) {
            setSettings($key,$_REQUEST[$key]);
        }
    }
}


 // If the config array is not empty, write it to the config.json file
if ($config) file_put_contents('../config.json', json_encode($config));
echo 'ok';