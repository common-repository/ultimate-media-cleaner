<?php

class UMC_CheckWoocommerce
{

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    function check(UMC_Attachment $attachment, UMC_Options $options, UMC_VerificationPlugin &$verification)
    {

        if (!$options->checkPlugin->wooCommerce) {
            return;
        }

        $this->checkDownloadable($attachment, $verification);
        $this->checkIdUsed($attachment, $verification);
    }

    private function checkDownloadable(UMC_Attachment $attachment, UMC_VerificationPlugin &$verification)
    {

        $dbPostmeta = $this->db->postmeta;

        $sql = "SELECT meta_id"
            . " FROM $dbPostmeta"
            . " WHERE meta_key IN ('_downloadable_files') "
            . " and option_value LIKE '%/$attachment->name%' limit 0,1";


        $verification->wooCommerce = $this->db->get_col($sql);

    }

    private function checkIdUsed(UMC_Attachment $attachment, UMC_VerificationPlugin &$verification)
    {

        $dbPostmeta = $this->db->postmeta;

        $sql = "SELECT meta_id"
            . " FROM $dbPostmeta"
            . " WHERE meta_key IN ('_thumbnail_id', '_product_image_gallery') "
            . " and option_value LIKE '%/$attachment->id%' limit 0,1";


        $verification->wooCommerce = $this->db->get_col($sql);

    }



}
