<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

$mapId = $_GET['map'];
$z = $_GET['z'];
$x = $_GET['x'];
$y = $_GET['y'];
$map = $_SESSION['map'];
var_dump($map);
exit;


$imagePath = $map->getImagePathFromCoordinates($z, $x, $y);
var_dump($imagePath);
//header("content-type: image/jpg");
//readfile($imagePath);