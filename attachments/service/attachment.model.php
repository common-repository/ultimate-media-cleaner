<?php

class UMC_Attachment
{

    public $id;
    public $name;
    public $status;
    public $directory;
    public $src;
    public $url;
    public $size;
    public $type;

    static function fromJSON($json)
    {
        $instance = new UMC_Attachment();
        $instance->id = $json['id'];
        $instance->name = $json['name'];
        $instance->status = $json['status'];
        $instance->directory = $json['directory'];
        $instance->src = $json['src'];
        $instance->url = $json['url'];
        $instance->size = $json['size'];
        $instance->type = $json['type'];
        return $instance;
    }
}


class UMC_Image
{

    static function fromAttachment(UMC_Attachment $attachment)
    {

        $instance = new UMC_Image();

        $instance->id = $attachment->id;
        $instance->name = $attachment->name;
        $instance->status = $attachment->status;
        $instance->directory = $attachment->directory;
        $instance->src = $attachment->src;
        $instance->url = $attachment->url;
        $instance->size = $attachment->size;
        $instance->type = $attachment->type;

        return $instance;
    }

    static function fromJSON($json)
    {
        $instance = new UMC_Image();
        $instance->id = $json['id'];
        $instance->name = $json['name'];
        $instance->status = $json['status'];
        $instance->directory = $json['directory'];
        $instance->src = $json['src'];
        $instance->url = $json['url'];
        $instance->size = $json['size'];
        $instance->type = $json['type'];

        $instance->sizeName = $json['sizeName'];
        $instance->width  = $json['width'];
        $instance->height = $json['height'];

        // not use, ignored for the moment
        // $instance->children

        return $instance;
    }


    public $id;
    public $name;
    public $status;
    public $directory;
    public $src; //the origin src
    public $url;
    public $size;
    public $type;
    public $children;
    public $sizeName;
    public $width;
    public $height;

}

