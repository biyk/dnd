<?php
$files = glob("img/*.*");
$result = [];
foreach ($files as $filename) {
  $time = \filectime($filename);
  $result[$time] = $filename;
}
ksort($result);

header ('Content-Type: image/png');
echo file_get_contents(end($result));