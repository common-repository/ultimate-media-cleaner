<?php

class UMC_CheckExcerptParentSql
{

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }


    function check(UMC_Attachment $attachment, UMC_Options $options, UMC_Verification &$verification)
    {

        if (!$options->check->excerpt || empty($attachment->id)) {
           return;
        }

        $posts = $this->db->posts;


        $sql = "SELECT id"
            . " FROM $posts"
            . " WHERE post_excerpt in "
            . "(SELECT post_parent FROM $posts"
            . " WHERE id=" . $attachment->id . " )"
            . " and post_excerpt LIKE '%/$attachment->name%'"
            . " limit 0,1";

        $verification->excerptParent = $this->db->get_col($sql);

    }

}
