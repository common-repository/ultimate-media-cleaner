<?php

class UMC_CheckPostMetaSql
{

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }


    function check(UMC_Attachment $attachment, UMC_Options $options, UMC_Verification &$verification)
    {

        if (!$options->check->postMeta) {
            return;
        }


        $postmeta = $this->db->postmeta;

        $sql = "SELECT post_id"
            . " FROM $postmeta"
            . " WHERE meta_key not in ('_wp_attachment_metadata','_wp_attached_file')"
            . " and meta_value LIKE '%/$attachment->src%'"
            . " limit 0,1";

        $verification->postMeta = $this->db->get_col($sql);

    }

}
