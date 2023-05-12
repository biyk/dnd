<?php

$type = $_REQUEST['type'];
$path = '../config.json';
$json_file = file_get_contents($path);

if ($type=='locale'){

    $json = json_decode($json_file, 1);
    $locales = explode(' ', $_REQUEST['text']);

    foreach ($json['videos'] as $name=>$video){
        foreach ($locales as $locale) {
            if ($name==$locale) $json['locale'] = $locale;
        }
    }

}


if ($json) file_put_contents($path, json_encode($json));
echo 'ok';