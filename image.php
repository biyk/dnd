<?php
require_once 'utils/func.php';
$files = glob("img/*.*");
$result = [];
foreach ($files as $filename) {
  $time = \filectime($filename);
  $result[$time] = $filename;
}
ksort($result);

$file = end($result);
$filetime = filectime($file);//windows


$status = json_decode(file_get_contents('status.ini'), 1);
if (!empty($status['back_timestamp']) && $status['back_timestamp'] == $filetime){
    //header($_SERVER['SERVER_PROTOCOL'] . ' 304 Not Modified');
    //exit;

}

if (empty($status)) $status = [];

$status['back_timestamp'] = $filetime;
safefilerewrite('status.ini', json_encode($status));
ob_end_clean();
header ('Content-Type: image/png');
echo file_get_contents($file);