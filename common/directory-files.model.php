<?php


class UMC_DirectoryFiles {

    //type string
    public $directory;
    //type array
    public $files;

    public function __construct($directory, $files = []) {
        $this->directory = $directory;
        $this->files = $files;
    }

    public function addFile($file) {
        if (!empty($file)) {
            $this->files[] = $file;
        }
    }

}
