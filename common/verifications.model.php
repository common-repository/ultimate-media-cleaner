<?php


class UMC_Verification
{

    const SKIPPED = 'SKIPPED';

    public $excerptAll;
    public $excerptParent;
    public $postAndPageAll;
    public $postAndPageParent;
    public $postMeta;

    public function __construct()
    {
        $this->excerptAll = self::SKIPPED;
        $this->excerptParent = self::SKIPPED;
        $this->postAndPageAll = self::SKIPPED;
        $this->postAndPageParent = self::SKIPPED;
        $this->postMeta = self::SKIPPED;
    }
}
