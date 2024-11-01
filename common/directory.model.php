<?php

class UMC_Directory {

    //type string
    public $base;
    //type array
    public $directories;

    public function __construct($base, $directories = []) {
        $this->base = $base;
        $this->directories = $directories;
    }

    public function addDirectory($directory) {
        if (!empty($directory)) {
            $this->directories[] = $directory;
        }
    }

    public function deleteDuplicate() {
        array_unique($this->directories);
    }

}
