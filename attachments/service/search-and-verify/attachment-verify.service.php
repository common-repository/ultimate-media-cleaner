<?php

class UMC_AttachmentVerifyService
{

    public function verify(UMC_Attachment $attachment, UMC_Options $options)
    {
        global $wpdb;
        $verifications = new UMC_Verification();

        $checkPostAndPageParent = new UMC_CheckPostAndPageParentSql($wpdb);
        $checkPostAndPageParent->check($attachment, $options, $verifications);

        $checkPostAndPage = new UMC_CheckPostAndPageAllSql($wpdb);
        $checkPostAndPage->check($attachment, $options, $verifications);

        $checkExcerptParent = new UMC_CheckExcerptParentSql($wpdb);
        $checkExcerptParent->check($attachment, $options, $verifications);

        // gloabl check, all site will have this kind of logic
        $checkExcerptAll = new UMC_CheckExcerptAllSql($wpdb);
        $checkExcerptAll->check($attachment, $options, $verifications);

        $checkPostMeta = new UMC_CheckPostMetaSql($wpdb);
        $checkPostMeta->check($attachment, $options, $verifications);

        // TODO: add their own endpoint for plugin checks
        $verificationsPlugin = new UMC_VerificationPlugin();

        $checkAstra = new UMC_CheckAstra($wpdb);
        $checkAstra->check($attachment, $options, $verificationsPlugin);

        $checkElementor = new UMC_CheckElementor($wpdb);
        $checkElementor->check($attachment, $options, $verificationsPlugin);

        $checkEWoocommerce = new UMC_CheckWoocommerce($wpdb);
        $checkEWoocommerce->check($attachment, $options, $verificationsPlugin);

        return [$verifications, $verificationsPlugin];
    }


}
