<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * This is a custom image manupulation library developed by raakesh.
 * @license GNU GPL
 * @author raakesh
 * Released under public license hence author takes no warranty of this code out of this project scope. However, modification of this code is allowed under GNU GPL license.
 */
class Image
{

    //put your code here
    var $image;
    var $image_type;
    var $image_name;

    public function display()
    {
        $this->load($_GET['image']);
        $this->image_name = $_GET['image'];
        if ($this->image_type == IMAGETYPE_JPEG)
            $this->check_orientation($_GET['image']);
        if (isset($_GET['w']) and !isset($_GET['h']))
            $this->resizeToWidth($_GET['w']);
        if (!isset($_GET['w']) and isset($_GET['h']))
            $this->resizeToHeight($_GET['h']);
        if (isset($_GET['w']) and isset($_GET['h']))
            $this->crop($_GET['w'], $_GET['h']);
        $this->output($this->image_type);
    }

    function load($filename)
    {
        $image_info = getimagesize($filename);
        $this->image_type = $image_info[2];
        if ($this->image_type == IMAGETYPE_JPEG) {
            $this->image = imagecreatefromjpeg($filename);
        } elseif ($this->image_type == IMAGETYPE_GIF) {
            $this->image = imagecreatefromgif($filename);
        } elseif ($this->image_type == IMAGETYPE_PNG) {
            $this->image = imagecreatefrompng($filename);
        }
    }

    function output($image_type = IMAGETYPE_JPEG)
    {
        header('Cache-Control: max-age=86400, public');
        if ($image_type == IMAGETYPE_JPEG) {
            header('Content-Type: image/jpeg');
            imagejpeg($this->image, NULL, 90);
        } elseif ($image_type == IMAGETYPE_GIF) {
            header('Content-Type: image/gif');
            imagegif($this->image);
        } elseif ($image_type == IMAGETYPE_PNG) {
            header('Content-Type: image/png');
            imagepng($this->image, NULL, 9);
        }
    }

    function getWidth()
    {
        return imagesx($this->image);
    }

    function getHeight()
    {
        return imagesy($this->image);
    }

    function resizeToHeight($height)
    {
        $ratio = $height / $this->getHeight();
        $width = $this->getWidth() * $ratio;
        $this->resize($width, $height);
    }

    function resizeToWidth($width)
    {
        $ratio = $width / $this->getWidth();
        $height = $this->getheight() * $ratio;
        $this->resize($width, $height);
    }
    function resize($width, $height)
    {
        $new_image = imagecreatetruecolor($width, $height);
        imagealphablending($new_image, false);
        imagesavealpha($new_image, true);
        $transparent = imagecolorallocatealpha($new_image, 255, 255, 255, 127);
        imagefilledrectangle($new_image, 0, 0, $width, $height, $transparent);
        imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
        $this->image = $new_image;
    }


    function crop($thumb_width, $thumb_height)
    {
        $width = $this->getWidth();
        $height = $this->getHeight();

        $original_aspect = $width / $height;
        $thumb_aspect = $thumb_width / $thumb_height;

        if ($original_aspect >= $thumb_aspect) {
            // If image is wider than thumbnail (in aspect ratio sense)
            $new_height = $thumb_height;
            $new_width = $width / ($height / $thumb_height);
        } else {
            // If the thumbnail is wider than the image
            $new_width = $thumb_width;
            $new_height = $height / ($width / $thumb_width);
        }

        $new_image = imagecreatetruecolor($thumb_width, $thumb_height);
        imagealphablending($new_image, false);
        imagesavealpha($new_image, true);
        $transparent = imagecolorallocatealpha($new_image, 255, 255, 255, 127);
        imagefilledrectangle($new_image, 0, 0, $thumb_width, $thumb_height, $transparent);
        // Resize and crop

        imagecopyresampled(
            $new_image,
            $this->image,
            0 - ($new_width - $thumb_width) / 2, // Center the image horizontally
            0 - ($new_height - $thumb_height) / 2, // Center the image vertically
            0,
            0,
            $new_width,
            $new_height,
            $width,
            $height
        );
        $this->image = $new_image;
    }


    function check_orientation($source)
    {
        $exif = exif_read_data($source);
        $ort = isset($exif['Orientation']) ? $exif['Orientation'] : '';

        switch ($ort) {

            case 2: // horizontal flip

                $this->ImageFlip();

                break;

            case 3: // 180 rotate left

                $this->image = imagerotate($this->image, 180, -1);

                break;

            case 4: // vertical flip

                $this->ImageFlip();

                break;

            case 5: // vertical flip + 90 rotate right

                $this->ImageFlip();

                $this->image = imagerotate($this->image, -90, -1);

                break;

            case 6: // 90 rotate right

                $this->image = imagerotate($this->image, -90, -1);

                break;

            case 7: // horizontal flip + 90 rotate right

                $this->ImageFlip();

                $this->image = imagerotate($this->image, -90, -1);

                break;

            case 8: // 90 rotate left

                $this->image = imagerotate($this->image, 90, -1);

                break;
            default:
                $this->image = $this->image;
                break;
        }
    }

    public function ImageFlip($x = 0, $y = 0, $width = null, $height = null)
    {

        if ($width < 1)
            $width = $this->getWidth();
        if ($height < 1)
            $height = $this->getHeight();

        // Truecolor provides better results, if possible.
        if (function_exists('imageistruecolor') && imageistruecolor($this->image)) {

            $tmp = imagecreatetruecolor(1, $height);
        } else {

            $tmp = imagecreate(1, $height);
        }

        $x2 = $x + $width - 1;

        for ($i = (int) floor(($width - 1) / 2); $i >= 0; $i--) {

            // Backup right stripe.
            imagecopy($tmp, $this->image, 0, 0, $x2 - $i, $y, 1, $height);

            // Copy left stripe to the right.
            imagecopy($this->image, $this->image, $x2 - $i, $y, $x + $i, $y, 1, $height);

            // Copy backuped right stripe to the left.
            imagecopy($this->image, $tmp, $x + $i, $y, 0, 0, 1, $height);
        }

        imagedestroy($tmp);

        return true;
    }
}
