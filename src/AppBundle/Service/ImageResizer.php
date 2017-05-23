<?php

namespace AppBundle\Service;

class ImageResizer
{
    public function resizeWidth($sourcePath, $resultPath, $width_max)
    {
        list($width_orig, $height_orig) = getimagesize($sourcePath);
        $orig_image = imagecreatefromjpeg($sourcePath);
        if ($width_orig > $width_max )
        {
            $ratio = $width_orig/$height_orig;
            $width = $width_max;
            $height = $width/$ratio;
            $image = imagecreatetruecolor($width, $height);
            imagecopyresampled($image, $orig_image, 0, 0, 0, 0,
                $width, $height, $width_orig, $height_orig);
            imagejpeg($image, $resultPath, 100);
            imagedestroy($image);
        }
        else
        {
            imagejpeg($orig_image, $resultPath, 100);
        }
        imagedestroy($orig_image);
    }

    public function resize($sourcePath, $resultPath, $width_max, $height_max)
    {
        list($width_orig, $height_orig) = getimagesize($sourcePath);
        $orig_image = imagecreatefromjpeg($sourcePath);
        if ($width_orig > $width_max && $height_orig <= $height_max) {
            $ratio = $width_orig/$height_orig;
            $width = $width_max;
            $height = $width/$ratio;
            $image = imagecreatetruecolor($width, $height);
            imagecopyresampled($image, $orig_image, 0, 0, 0, 0,
                $width, $height, $width_orig, $height_orig);
            imagejpeg($image, $resultPath, 100);
            imagedestroy($image);
        }
        elseif ($height_orig > $height_max && $width_orig <= $width_max) {
            $ratio = $width_orig/$height_orig;
            $height = $height_max;
            $width = $height * $ratio;
            $image = imagecreatetruecolor($width, $height);
            imagecopyresampled($image, $orig_image, 0, 0, 0, 0,
                $width, $height, $width_orig, $height_orig);
            imagejpeg($image, $resultPath, 100);
            imagedestroy($image);
        }
        elseif ($height_orig > $height_max && $width_orig > $width_max) {
            $ratio = $width_orig/$height_orig;
            $ratio_max = $width_max/$height_max;

            if ($ratio <= $ratio_max) {
                $height = $height_max;
                $width = $height * $ratio;
            }
            else {
                $width = $width_max;
                $height = $width / $ratio;
            }
            $image = imagecreatetruecolor($width, $height);
            imagecopyresampled($image, $orig_image, 0, 0, 0, 0,
                $width, $height, $width_orig, $height_orig);
            imagejpeg($image, $resultPath, 100);
            imagedestroy($image);
        }
        else {
            imagejpeg($orig_image, $resultPath, 100);
        }
        imagedestroy($orig_image);
    }
}