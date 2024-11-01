<?php

class UMC_AttachmentSearchServerService
{

    private $directoryService;
    private $attachmentSql;
    private $attachmentSearchDbService;

    public function __construct()
    {
        $this->directoryService = new UMC_DirectoryService();
        $this->attachmentSql = new UMC_AttachmentSql();
        $this->attachmentSearchDbService = new UMC_AttachmentSearchDbService();
    }


    function getDirectories() {
      return  $this->directoryService->getDirectories(UMC_WP_UPLOAD_PATH);
    }

    function getFilesFromDirectory($directory) {
        return  $this->directoryService->getFilesFromDirectory($directory);
    }

    function findIdForNameAndDirectory($name, $directory) {

        $url = $this->directoryService->fileUrl($directory, $name);

        $id = attachment_url_to_postid($url);

        if ($id !== 0) {
            return $this->attachmentSearchDbService->convertIdToFile($id);
        }

        $id = $this->attachmentSql->findIdFromNameAndDirectory($name, $directory);

        if (!empty($id)) {
            return $this->attachmentSearchDbService->convertIdToFile($id);
        }
        return null;


    }

}
