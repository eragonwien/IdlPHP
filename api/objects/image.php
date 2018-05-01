<?php
class Image 
{
    private $folder = '../image';
    private $default = '../image/default.jpg';
    private $id;

    public function __construct($id) {
        $this->id = $id;
    }

    public function get() {
        $path = $this->folder . '/' . $this->id . '.jpg';
        $image = (file_exists($path)) ? $path : $this->default;
        return file_get_contents($image);
    }

    public function create($file) {
        $path = $this->folder . '/' . $this->id . '.jpg';
        $upload = move_uploaded_file($file, $path);

        return ($upload) ? true : false;
    }

    public function update($file) {
        $this->delete();
        $success = $this->create($file);
        return $success;
    }

    public function delete() {
        $path = $this->folder . '/' . $this->id . '.jpg';
        if (file_exists($path)) {
            unlink($path);
            return true;
        }
        return false;
    }
}
