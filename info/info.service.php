<?php


class UMC_InfoService {


   function getPhpVersion() {
        return phpinfo();
    }

    function isAdmin() {
        return current_user_can('administrator');
    }

}
