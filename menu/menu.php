<?php

// only for admin users
add_action('admin_menu', 'umc_admin_menu');

function umc_admin_menu()
{


    /* Add our plugin submenu and administration screen */
    $page_hook_suffix = add_submenu_page('tools.php', // The parent page of this submenu
        __('Ultimate media cleaner', 'umc'), // The submenu title
        __('Ultimate media cleaner', 'umc'), // The screen title
        'activate_plugins', // The capability required for access to this submenu
        'umc', // The slug to use in the URL of the screen
        'umc_display_menu' // The function to call to display the screen
    );


    add_action('admin_enqueue_scripts', 'umc_load_scripts');

}

function umc_load_scripts($hook)
{
    if($hook == 'tools_page_umc') {
        wp_register_script('umc-runtime', plugins_url('../js/runtime.js', __FILE__), array(), UMC_JS_VERSION);
        wp_register_script('umc-polyfills', plugins_url('../js/polyfills.js', __FILE__), array(), UMC_JS_VERSION);
        wp_register_style('umc-styles', plugins_url('../js/styles.css', __FILE__), array(), UMC_JS_VERSION);
        wp_register_script('umc-main', plugins_url('../js/main.js', __FILE__), array(), UMC_JS_VERSION);


        /* Link our already registered script to a page */
        wp_enqueue_script('umc-runtime', '', array(), false, true);
        wp_enqueue_script('umc-polyfills', '', array(), false, true);
        wp_enqueue_style('umc-styles', '', array(), false, true);
        wp_enqueue_script('umc-main', '', array(), false, true);
    }


}

function umc_display_menu()
{
    $nonce = wp_create_nonce( 'wp_rest' );


    echo "<umc-root nonce=\"$nonce\"></umc-root>";
}
