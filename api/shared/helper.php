<?php
class Helper 
{
    public function isFileValidImage($file) {
        // is file an image
        $isImage = getimagesize($file);
        if (!$isImage) {
            return false;
        };
        return true;
    }
}