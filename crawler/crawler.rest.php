<?php

class UMC_CrawlerRest
{

    public $optionCrawlerService;

    public function __construct()
    {
        $this->optionCrawlerService = new UMC_OptionCrawlerService();
    }

    function addRestEndpoint()
    {
        add_action('rest_api_init', array($this, 'restEndpoints'));
    }

    function restEndpoints()
    {

        register_rest_route(UMC_ENDPOINT, '/crawler/validation/(?P<UUID>[a-zA-Z0-9\-]+)', array(
                'methods' => 'GET',
                'callback' => [$this, 'treatUUIDGet'],
            )
        );

        register_rest_route(UMC_ENDPOINT, '/crawler/option', array(
                'methods' => 'POST',
                'callback' => [$this, 'treatSaveOptionCrawlerPost'],
                'permission_callback' => function () {
                    return current_user_can('administrator');
                }
            )
        );

        register_rest_route(UMC_ENDPOINT, '/crawler/option', array(
                'methods' => 'GET',
                'callback' => [$this, 'treatOptionCrawlerGET'],
                'permission_callback' => function () {
                    return current_user_can('administrator');
                }
            )
        );
    }

    function treatUUIDGet($request)
    {
        $uuid = $request->get_param('UUID');

        $optionCrawler = $this->optionCrawlerService->getOptionsCrawler();

        $isValidUUID = $uuid == $optionCrawler["uuid"];

        $httpCode = 404;
        if ($isValidUUID) {
            $httpCode = 200;
        }
        $response = new WP_REST_Response($httpCode);

        $response->set_headers(wp_get_nocache_headers());
        return $response;

    }


    function treatSaveOptionCrawlerPost($request)
    {
        $optionsCrawler = $request->get_json_params();
        $this->optionCrawlerService->addOrUpdateOptionCrawler($optionsCrawler);
        $response = new WP_REST_Response(200);
        $response->set_headers(wp_get_nocache_headers());
        return $response;

    }

    function treatOptionCrawlerGET()
    {

        $optionCrawler = $this->optionCrawlerService->getOptionsCrawler();
        $response = new WP_REST_Response($optionCrawler, 200);
        $response->set_headers(wp_get_nocache_headers());
        return $response;

    }

}


$instance = new UMC_CrawlerRest();
$instance->addRestEndpoint();
