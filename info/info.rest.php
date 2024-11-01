<?php
class UMC_InfoRest
{

    public $infoService;

    public function __construct()
    {
        $this->infoService = new UMC_InfoService();
    }

    function addRestEndpoint()
    {
        add_action('rest_api_init', array($this, 'restEndpoints'));
    }

    function restEndpoints()
    {

        register_rest_route(UMC_ENDPOINT, '/info', array(
                'methods' => 'GET',
                'callback' => [$this, 'treatInfoGet'],
                'permission_callback' => function () {
                    return current_user_can('administrator');
                }
            )
        );

    }

    function treatInfoGet() {

    }
}
