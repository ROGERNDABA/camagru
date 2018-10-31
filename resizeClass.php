<?php
/*
 *
 *    File created by Roger Ndaba
 *    Project: camagru
 *    File: resizeClass.php
 *
 */


 function resizeImage($imageNew, $newWidth, $newHeight) {
    $imageInfo = getimagesize($imageNew);

    $image = imagecreatefrompng($imageNew);
    imagesavealpha($image, true);

    $newImg = imagecreatetruecolor($newWidth, $newHeight);
    imagealphablending($newImg, false);
    imagesavealpha($newImg,true);
    $transparent = imagecolorallocatealpha($newImg, 255, 255, 255, 127);
    imagefilledrectangle($newImg, 0, 0, $newWidth, $newHeight, $transparent);
    imagecopyresampled($newImg, $image, 0, 0, 0, 0, $newWidth, $newHeight,  $imageInfo[0], $imageInfo[1]);

    ob_start();
    imagepng($newImg);

    $contents = ob_get_contents();
    ob_end_clean();
    return ($contents);
    imagedestroy($newImg);
 }
?>