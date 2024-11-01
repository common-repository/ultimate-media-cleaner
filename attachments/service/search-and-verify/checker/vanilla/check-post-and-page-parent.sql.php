<?php


class UMC_CheckPostAndPageParentSql
{

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }


    function check(UMC_Attachment $attachment, UMC_Options $options, UMC_Verification &$verification)
    {

        if (empty($attachment->id)) {
            return;
        }

        $posts = $this->db->posts;

        $sql = "SELECT id"
            . " FROM $posts"
            . " WHERE  post_parent in"
            . " (SELECT post_parent FROM $posts"
            . " WHERE id=" . $attachment->id . " )"
            . " and post_content LIKE '%/$attachment->name%'";

        $verification->postAndPageParent =  $this->db->get_col($sql);
    }

}
