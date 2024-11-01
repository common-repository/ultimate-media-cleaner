<?php

class UMC_CheckElementor
{

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    function check(UMC_Attachment $attachment, UMC_Options $options, UMC_VerificationPlugin &$verification)
    {

        if (!$options->check->elementor) {
            return;
        }

        $dbPostmeta = $this->db->postmeta;


        $sql = "SELECT meta_id"
            . " FROM $dbPostmeta"
            . " WHERE meta_key = '_elementor_data' "
            . " and option_value LIKE '%/$attachment->name%' limit 0,1";


        $verification->excerptAll = $this->db->get_col($sql);

    }

}
