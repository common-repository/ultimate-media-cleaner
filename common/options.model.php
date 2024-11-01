<?php


class UMC_Options
{

    public $check;
    public $checkPlugin;

    public function __construct()
    {
        $this->check = new Check();
        $this->checkPlugin = new CheckPlugin();
    }


    static function fromJSON($json)
    {
        $instance = new UMC_Options();
        $instance->check->shortCode = $json['check']['shortCode'];
        $instance->check->excerpt = $json['check']['excerpt'];
        $instance->check->postMeta = $json['check']['postMeta'];
        $instance->check->draft = $json['check']['draft'];

        $instance->checkPlugin->astra = $json['checkPlugin']['astra'];
        $instance->checkPlugin->elementor = $json['checkPlugin']['elementor'];
        $instance->checkPlugin->wooCommerce = $json['checkPlugin']['wooCommerce'];


    }

}


class Check
{

    public $shortCode = true;
    public $excerpt = true;
    public $postMeta = true;
    public $draft = true;

}



// TODO: check if plugin are in wp
class CheckPlugin
{

    public $astra = true;
    public $elementor = true;
    public $wooCommerce = true;
}
