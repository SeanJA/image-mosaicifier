<?php

require 'mosaic.class.php';

$imageURL = 'title.jpg';
// make sure it is an image?

$sharpness = 3;

$m = new mosaic();
$m->setImageURL($imageURL);
$m->setSharpness($sharpness);
echo $m->getMosaic();