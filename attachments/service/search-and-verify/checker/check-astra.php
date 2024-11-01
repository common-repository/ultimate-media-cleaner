<?php

class UMC_CheckAstra
{

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    function check(UMC_Attachment $attachment, UMC_Options $options, UMC_VerificationPlugin &$verification)
    {

        if (!$options->check->astra) {
            return;
        }

        $dbOptions = $this->db->options;


            $sql = "SELECT option_id"
                . " FROM $dbOptions"
                . " WHERE option_name IN ('astra-settings', '_astra_sites_old_site_options') "
                . " and option_value LIKE '%/$attachment->name%' limit 0,1";


        $verification->excerptAll = $this->db->get_col($sql);

    }

}
