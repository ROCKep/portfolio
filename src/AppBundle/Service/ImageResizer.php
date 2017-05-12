<?php

namespace AppBundle\Service;

class ImageResizer
{
    public function resizeWidth($filePath, $width_max)
    {
        list($width_orig, $height_orig) = getimagesize($filePath);
        if ($width_orig > $width_max )
        {
            $ratio = $width_orig/$height_orig;
            $width = $width_max;
            $height = $width/$ratio;
            $orig_image = imagecreatefromjpeg($filePath);
            $image = imagecreatetruecolor($width, $height);
            imagecopyresampled($image, $orig_image, 0, 0, 0, 0,
                $width, $height, $width_orig, $height_orig);
            imagejpeg($image, $filePath, 100);
            imagedestroy($orig_image);
            imagedestroy($image);
        }
    }
}