<?php
include '../utils/func.php';
$file = $_REQUEST['file'];

$map = getSettings('map');

echo file_get_contents('../json/'.$map.'/'.$file);