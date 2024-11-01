<?php

class UMC_VerificationPlugin
{

    const SKIPPED = 'SKIPPED';

    public $astra;
    public $elementor;
    public $wooCommerce;

    public function __construct()
    {
        $this->astra = self::SKIPPED;
        $this->elementor = self::SKIPPED;
        $this->wooCommerce = self::SKIPPED;
    }
}
