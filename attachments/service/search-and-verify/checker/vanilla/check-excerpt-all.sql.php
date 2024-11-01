<?php

class UMC_CheckExcerptAllSql
{

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    function check(UMC_Attachment $attachment, UMC_Options $options, UMC_Verification &$verification)
    {

        if (!$options->check->excerpt) {
            return;
        }

        if (is_array($verification->excerptParent)
            && count($verification->excerptParent) > 0) {
            return;
        }

        $posts = $this->db->posts;

        if ($options->check->draft) {
            $sql = "SELECT id"
                . " FROM $posts"
                . " WHERE post_excerpt is not null and post_excerpt!=''"
                . " and post_type not in ('attachment','nav_menu_item')"
                . " and post_excerpt LIKE '%/$attachment->name%' limit 0,1";
        } else {
            $sql = "SELECT id"
                . " FROM $posts"
                . " WHERE post_excerpt is not null and post_excerpt!=''"
                . " and post_type not in ('attachment','nav_menu_item','revision')"
                . " and post_status !='draft'"
                . " and post_excerpt LIKE '%/$attachment->name%' limit 0,1";
        }

        $verification->excerptAll = $this->db->get_col($sql);

    }

}
