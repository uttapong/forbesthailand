<?php
session_start();

	$KEY = $_REQUEST['Key'];

	$_SESSION['SecurityText'.$KEY] = rand(10000,99999);
	$TEXT = $_SESSION['SecurityText'.$KEY];
	
	// Create a blank image and add some text
	$im = imagecreate(60, 20);
	imagecolorallocate($im,244,244,244);
	$text_color = imagecolorallocate($im, 255, 0, 0);
	imagestring($im, 6, 8, 2,  $TEXT, $text_color);
	
	// Set the content type header - in this case image/jpeg
	header('Content-type: image/jpeg');
	
	// Output the image
	imagejpeg($im);
	
	// Free up memory
	imagedestroy($im);


?> 