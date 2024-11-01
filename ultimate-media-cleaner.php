<?php
/**
 * Plugin Name:       Ultimate media cleaner
 * Plugin URI:        https://www.nicearma.com
 * Description:       Ultimate media cleaner
 * Version:           2.6.1
 * Requires at least: 5.5
 * Requires PHP:      7.2
 * Author:            Nicolas ARMANDO
 * Author URI:        https://www.nicearma.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       ultimate-media-cleaner
 * Domain Path:       /languages
 */

define('UMC_ENDPOINT', 'ultimate-media-cleaner/v1');
define('UMC_PLUGIN_PATH', dirname(__FILE__));
define('UMC_WP_UPLOAD_PATH', wp_upload_dir()['basedir']);
define('UMC_WP_UPLOAD_URL', wp_upload_dir()['baseurl']);
define('UMC_DB_VERSION', 1);
define('UMC_JS_VERSION', '2.6.1');


include_once(UMC_PLUGIN_PATH . '/common/index.php');
include_once(UMC_PLUGIN_PATH . '/translation/index.php');
include_once(UMC_PLUGIN_PATH . '/attachments/index.php');
include_once(UMC_PLUGIN_PATH . '/page/index.php');
include_once(UMC_PLUGIN_PATH . '/options/index.php');
include_once(UMC_PLUGIN_PATH . '/crawler/index.php');

include(UMC_PLUGIN_PATH . '/menu/menu.php');

register_uninstall_hook(__FILE__, 'umc_uninstall_and_clean');


function umc_uninstall_and_clean()
{

    $optionsService = new UMC_OptionsService();
}
