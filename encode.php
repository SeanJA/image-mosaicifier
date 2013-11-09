<?php

require 'mosaic.class.php';

$imageURL = $_GET['image_url'];
// make sure it is an image?


$sharpness = isset($_GET['sharpness'])? (int)$_GET['sharpness'] : 10;

if($sharpness < 10){
	$sharpness = 10;
}

$m = new mosaic();
$m->setImageURL($imageURL);
$m->setSharpness($sharpness);
echo $m->getMosaic();