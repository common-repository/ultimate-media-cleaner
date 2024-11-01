<?php

abstract class UMC_AttachmentType {

    const IMAGE = 'IMAGE';
    const ALL = 'ALL';
    const REGULAR = 'REGULAR';
    const UNKNOWN = 'UNKNOWN';
    
    public static function typeFromMime($mime) {
        $type = self::UNKNOWN;
        if(!empty($mime)) {
          $mime= explode('/', $mime);
          $type= $mime[0];
        }
        return $type;
    }
    
    public static function isImage($type) {
        return strstr($type, self::IMAGE) !== false;
          
    }

}
