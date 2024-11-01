<?php


include_once(UMC_PLUGIN_PATH . '/attachments/service/attachment.model.php');

// search-and-verify
include_once(UMC_PLUGIN_PATH . '/attachments/service/search-and-verify/checker/vanilla/check-excerpt-all.sql.php');
include_once(UMC_PLUGIN_PATH . '/attachments/service/search-and-verify/checker/vanilla/check-excerpt-parent.sql.php');
include_once(UMC_PLUGIN_PATH . '/attachments/service/search-and-verify/checker/vanilla/check-post-and-page-all.sql.php');
include_once(UMC_PLUGIN_PATH . '/attachments/service/search-and-verify/checker/vanilla/check-post-and-page-parent.sql.php');
include_once(UMC_PLUGIN_PATH . '/attachments/service/search-and-verify/checker/vanilla/check-post-meta.sql.php');

include_once(UMC_PLUGIN_PATH . '/attachments/service/search-and-verify/checker/check-astra.php');
include_once(UMC_PLUGIN_PATH . '/attachments/service/search-and-verify/checker/check-elementor.php');
include_once(UMC_PLUGIN_PATH . '/attachments/service/search-and-verify/checker/check-woocommerce.php');

include_once(UMC_PLUGIN_PATH . '/attachments/service/search-and-verify/attachment-search.sql.php');
include_once(UMC_PLUGIN_PATH . '/attachments/service/search-and-verify/images-search.sql.php');

include_once(UMC_PLUGIN_PATH . '/attachments/service/search-and-verify/attachment-status.enum.php');
include_once(UMC_PLUGIN_PATH . '/attachments/service/search-and-verify/attachment-type.enum.php');

include_once(UMC_PLUGIN_PATH . '/attachments/service/search-and-verify/attachment-search-db.service.php');
include_once(UMC_PLUGIN_PATH . '/attachments/service/search-and-verify/attachment-search-server.service.php');
include_once(UMC_PLUGIN_PATH . '/attachments/service/search-and-verify/attachment-verify.service.php');

// delete
include_once(UMC_PLUGIN_PATH . '/attachments/service/delete/attachment-delete.model.php');
include_once(UMC_PLUGIN_PATH . '/attachments/service/delete/attachment-delete.service.php');

include_once(UMC_PLUGIN_PATH . '/attachments/attachments.rest.php');
