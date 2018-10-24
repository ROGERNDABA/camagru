<?php
/*
 *
 *    File created by Roger Ndaba
 *    Project: camagru
 *    File: superimpose.php
 *
 */

$stamp = imagecreatefrompng('./images/film.png');
$im = imagecreatefrompng('./images/start.png');
$stw = imagesx($im);
$marge_bottom = 0;
$marge_right = 0;

$sx = imagesx($stamp);
$sy = imagesy($stamp);
imagecopyresampled($im, $stamp, $marge_right, $marge_bottom, 0, 0, $stw, $stw, imagesx($stamp), imagesy($stamp));


// header("Content-Type: image/jpeg");
imagepng($im, "yo.png");
 ?>

 <img src="./yo.png" alt="superimposing images using php"/>