<?php


class UMC_PageRest
{

    public $pageService;

    public function __construct()
    {
        $this->pageService = new UMC_PageService();
    }

    function addRestEndpoint()
    {
        add_action('rest_api_init', array($this, 'restEndpoints'));
    }

    function restEndpoints()
    {

        register_rest_route(UMC_ENDPOINT, '/pages/url', array(
                'methods' => 'GET',
                'callback' => [$this, 'treatPagesUrlGet'],
                'permission_callback' => function () {
                    return current_user_can('administrator');
                }
            )
        );

    }

    function treatPagesUrlGet()
    {
        $links = $this->pageService->getAllPageUrl();
        $response = new WP_REST_Response($links, 200);
        $response->set_headers(wp_get_nocache_headers());
        return $response;
    }


}

$instance = new UMC_PageRest();
$instance->addRestEndpoint();