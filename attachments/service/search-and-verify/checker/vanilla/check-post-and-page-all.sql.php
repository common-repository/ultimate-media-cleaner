<?php

class UMC_CheckPostAndPageAllSql {


    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }


    function check(UMC_Attachment $attachment, UMC_Options $options, UMC_Verification &$verification) {

        if(is_array($verification->postAndPageParent)
        && count($verification->postAndPageParent) > 0) {
            return;
        }

        $posts = $this->db->posts;

        if ($options->check->draft) {
            $sql = "SELECT id"
                    . " FROM $posts"
                    . " WHERE post_content is not null"
                    . " and post_content!=''"
                    . " and post_type not in ('attachment','nav_menu_item')"
                    . " and post_content LIKE '%/$attachment->name%'"
                    . " limit 0,1";
        } else {
            $sql = "SELECT id"
                    . " FROM $posts"
                    . " WHERE post_content is not null and post_content!=''"
                    . " and post_type not in ('attachment','nav_menu_item','revision')"
                    . " and post_status !='draft'"
                    . " and post_content LIKE '%/$attachment->name%'"
                    . " limit 0,1";
        }

        $verification->postAndPageAll = $this->db->get_col($sql);
    }

}
