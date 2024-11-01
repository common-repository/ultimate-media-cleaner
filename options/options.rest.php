<?php


class UMC_OptionsRest
{

    public $optionsService;

    public function __construct()
    {
        $this->optionsService = new UMC_OptionsService();
    }

    function addRestEndpoint()
    {
        add_action('rest_api_init', array($this, 'restEndpoints'));
    }

    function restEndpoints()
    {

        register_rest_route(UMC_ENDPOINT, '/options/crawler', array(
                'methods' => 'GET',
                'callback' => [$this, 'treatOptionsCrawlerGet'],
                'permission_callback' => function () {
                    return current_user_can('administrator');
                }
            )
        );

        register_rest_route(UMC_ENDPOINT, '/options/crawler', array(
                'methods' => 'POST',
                'callback' => [$this, 'treatOptionsCrawlerPost'],
                'permission_callback' => function () {
                    return current_user_can('administrator');
                }
            )
        );
    }

    function treatOptionsCrawlerGet()
    {
        $options = $this->optionsService->getOptionsCrawler();
        $response = new WP_REST_Response($options, 200);
        $response->set_headers(wp_get_nocache_headers());
        return $response;
    }

    function treatOptionsCrawlerPost($request)
    {
        $optionsCrawler = $request->get_json_params();
        $this->optionsService->addOrUpdateOptionCrawler($optionsCrawler);
        $response = new WP_REST_Response(200);
        $response->set_headers(wp_get_nocache_headers());
        return $response;

    }

}

$instance = new UMC_OptionsRest();
$instance->addRestEndpoint();
