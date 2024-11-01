<?php


class UMC_AttachmentRest
{

    public $attachmentSearchServiceDb;
    public $attachmentSearchServiceServer;
    public $attachmentVerifyService;
    public $attachmentDeleteService;

    public function __construct()
    {
        $this->attachmentSearchServiceDb = new UMC_AttachmentSearchDbService();
        $this->attachmentSearchServiceServer = new UMC_AttachmentSearchServerService();
        $this->attachmentVerifyService = new UMC_AttachmentVerifyService();
        $this->attachmentDeleteService = new UMC_AttachmentDeleteService();
    }

    function addRestEndpoint()
    {
        add_action('rest_api_init', array($this, 'restEndpoints'));
    }

    function restEndpoints()
    {

        register_rest_route(UMC_ENDPOINT, '/attachments/count/(?P<type>[a-zA-Z]+)', array(
                'methods' => 'GET',
                'callback' => [$this, 'treatAttachmentsCountGet'],
                'permission_callback' => function () {
                    return current_user_can('administrator');
                }
            )
        );

        register_rest_route(UMC_ENDPOINT, '/attachments/directories', array(
                'methods' => 'GET',
                'callback' => [$this, 'treatAttachmentsDirectoriesGet'],
                'permission_callback' => function () {
                    return current_user_can('administrator');
                }
            )
        );

        register_rest_route(UMC_ENDPOINT, '/attachments/directory/files', array(
                'methods' => 'POST',
                'callback' => [$this, 'treatAttachmentsDirectoryFilesPost'],
                'permission_callback' => function () {
                    return current_user_can('administrator');
                }
            )
        );

        register_rest_route(UMC_ENDPOINT, '/attachments/directory/file/id', array(
                'methods' => 'POST',
                'callback' => [$this, 'treatFindIdForNameAndDirectoryPost'],
                'permission_callback' => function () {
                    return current_user_can('administrator');
                }
            )
        );



        register_rest_route(UMC_ENDPOINT, '/attachment', array(
                'methods' => 'GET',
                'callback' => [$this, 'treatAttachmentByIdGet'],
                'args' => array(
                    'id' => array('required' => true)
                ),
                'permission_callback' => function () {
                    return current_user_can('administrator');
                }
            )
        );

        register_rest_route(UMC_ENDPOINT, '/attachments', array(
                'methods' => 'GET',
                'callback' => [$this, 'treatAttachmentsGet'],
                'args' => array(
                    'limit' => array('required' => true),
                    'page' => array('required' => true),
                    'type' => array('required' => true),
                ),
                'permission_callback' => function () {
                    return current_user_can('administrator');
                }
            )
        );


        register_rest_route(UMC_ENDPOINT, '/attachment/verify', array(
                'methods' => 'POST',
                'callback' => [$this, 'treatVerifyPost'],
                'permission_callback' => function () {
                    return current_user_can('administrator');
                }
            )
        );

        register_rest_route(UMC_ENDPOINT, '/attachment/delete', array(
                'methods' => 'POST',
                'callback' => [$this, 'treatDeletePost'],
                'permission_callback' => function () {
                    return current_user_can('administrator');
                }
            )
        );

        register_rest_route(UMC_ENDPOINT, '/attachment/delete/child', array(
                'methods' => 'POST',
                'callback' => [$this, 'treatDeleteChildPost'],
                'permission_callback' => function () {
                    return current_user_can('administrator');
                }
            )
        );

    }

    function treatAttachmentsGet($request)
    {
        $limit = $request->get_param('limit');
        $page = $request->get_param('page');
        $type = $request->get_param('type');
        $attachmentsByPage = $this->attachmentSearchServiceDb->get($type, $page, $limit);

        $response = new WP_REST_Response($attachmentsByPage, 200);;
        $response->set_headers(wp_get_nocache_headers());
        return $response;

    }

    function treatAttachmentsDirectoriesGet($request) {
        $directories = $this->attachmentSearchServiceServer->getDirectories();

        $response = new WP_REST_Response($directories, 200);;
        $response->set_headers(wp_get_nocache_headers());
        return $response;
    }


    function treatAttachmentsDirectoryFilesPost($request) {

        $json = $request->get_json_params();
        $directory = $json['directory'];

        $directoryFiles = $this->attachmentSearchServiceServer->getFilesFromDirectory($directory);

        $response = new WP_REST_Response($directoryFiles, 200);;
        $response->set_headers(wp_get_nocache_headers());
        return $response;
    }

    function treatFindIdForNameAndDirectoryPost($request) {

        $json = $request->get_json_params();
        $directory = $json['directory'];
        $name = $json['name'];

        $attachment = $this->attachmentSearchServiceServer->findIdForNameAndDirectory($name, $directory);

        $response = new WP_REST_Response($attachment, 200);;
        $response->set_headers(wp_get_nocache_headers());
        return $response;
    }




    function treatAttachmentByIdGet($request)
    {
        $id = $request->get_param('id');

        $attachmentById = $this->attachmentSearchServiceDb->findById($id);

        $response = new WP_REST_Response($attachmentById, 200);;
        $response->set_headers(wp_get_nocache_headers());
        return $response;

    }


    function treatVerifyPost($request)
    {

        $json = $request->get_json_params();
        $attachment = UMC_Attachment::fromJSON($json['attachment']);
        $verifications = $this->attachmentVerifyService->verify($attachment, new UMC_Options());

        $response = new WP_REST_Response(['vanilla' => $verifications[0], 'plugin' => $verifications[1]], 200);
        $response->set_headers(wp_get_nocache_headers());
        return $response;

    }

    function treatDeletePost($request)
    {

        $json = $request->get_json_params();
        $attachment = UMC_Attachment::fromJSON($json['attachment']);

        if(!empty($attachment->id)) {
            $attachmentVerifications = $this->attachmentDeleteService->delete($attachment);
        } else {
            $attachmentVerifications = $this->attachmentDeleteService->deleteWithoutId($attachment);
        }

        $response = new WP_REST_Response($attachmentVerifications, 200);;
        $response->set_headers(wp_get_nocache_headers());
        return $response;

    }

    function treatDeleteChildPost($request)
    {
        $json = $request->get_json_params();
        $attachment = UMC_Image::fromJSON($json['attachment']);

        $attachmentVerifications = $this->attachmentDeleteService->deleteChild($attachment);

        $response = new WP_REST_Response($attachmentVerifications, 200);
        $response->set_headers(wp_get_nocache_headers());
        return $response;

    }

    function treatAttachmentsCountGet($request)
    {
        $type = $request->get_param('type');
        $total = $this->attachmentSearchServiceDb->count($type);
        $response = new WP_REST_Response($total, 200);;
        $response->set_headers(wp_get_nocache_headers());
        return $response;
    }
}

$instance = new UMC_AttachmentRest();
$instance->addRestEndpoint();
