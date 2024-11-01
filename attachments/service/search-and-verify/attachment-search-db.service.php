<?php

class UMC_AttachmentSearchDbService {

    private $directoryService;

    public function __construct()
    {
        $this->directoryService = new UMC_DirectoryService();
    }


    public function count($type) {

        $sqlCall = $this->getSearchSql($type);
        $total = $sqlCall->count();
        return $total;
    }


    public function get($type, $page, $limit, $order = 0) {

        $sqlCall = $this->getSearchSql($type);
        $ids = call_user_func_array(array($sqlCall, 'get'), array($page, $limit, $order));

        $files = array();

        foreach ($ids as $id) {
            $files[] = $this->convertIdToFile($id);
        }

        return $files;
    }

    public function findById($id) {
        return $this->convertIdToFile($id);
    }

    public function convertIdToFile($id) {
        $wpAttachment = wp_get_attachment_metadata($id);

        $attachment = null;

        $haveMetaInformation = !empty($wpAttachment) && array_key_exists('file', $wpAttachment);

        if ($haveMetaInformation) {

            $baseDirs = explode('/', $wpAttachment["file"]);
            $name = array_pop($baseDirs);
            $directory = $this->cleanOrAddSlashDirectory(implode('/', $baseDirs) . '/');

            $attachment = $this->convertToAttachment($id, $name, $directory);

            $isImage = array_key_exists('sizes', $wpAttachment);
            if ($isImage) {

                $attachment = UMC_Image::fromAttachment($attachment);
                $attachment->sizeName = 'original';
                $attachment->height = $wpAttachment['height'];
                $attachment->width = $wpAttachment['width'];
                $attachment->children = $this->getImageChildren($id, $wpAttachment['sizes'], $attachment->directory, $directory);
            }
        } else {
            //get other type of file
            $wpFilePath = str_replace(UMC_WP_UPLOAD_PATH, '', get_attached_file($id));

            $baseDirs = explode('/', $wpFilePath);
            $name = array_pop($baseDirs);
            $directory = $this->cleanOrAddSlashDirectory( implode('/', $baseDirs) . '/');
            $attachment = $this->convertToAttachment($id, $name, $directory);
        }
        return $attachment;
    }

    private function cleanOrAddSlashDirectory($directory) {
        if(substr($directory, 0, 1) == "/") {
            return $directory;
        }
        if(substr($directory, 0, 1) != "/") {
            return '/' . $directory;
        }

        return $directory;
    }


    private function convertToAttachment($id, $name, $directory) {
        $file = new UMC_Attachment();
        $file->id = $id;
        $file->name = $name;
        $file->status = UMC_AttachmentStatus::UNKNOWN;
        $file->directory = $directory;
        $file->url = $this->directoryService->fileUrl($directory, $name);
        $file->src = $this->directoryService->filePath($directory, $name);
        $file->size = filesize($file->src);
        $file->type = $this->directoryService->mimeType($file->src);
        return $file;
    }

    private function getImageChildren($id, $sizes, $path, $directory) {
        $imageSizes = [];
        foreach ($sizes as $name => $size) {
            $imageSize = new UMC_Image();
            $imageSize->id = $id;
            $imageSize->name = $size['file'];
            $imageSize->directory = $path;
            $imageSize->src = $this->directoryService->filePath($directory, $imageSize->name);
            $imageSize->url = $this->directoryService->fileUrl($directory, $imageSize->name);
            $imageSize->height = $size['height'];
            $imageSize->width = $size['width'];
            $imageSize->sizeName = $name;
            $imageSize->status = UMC_AttachmentStatus::UNKNOWN;
            $imageSize->size = $this->directoryService->fileSize($imageSize->src);
            $imageSize->type = $this->directoryService->mimeType($imageSize->src);
            $imageSizes[] = $imageSize;
        }
        return $imageSizes;
    }



    private function getSearchSql($type) {
        switch ($type) {
            case UMC_AttachmentType::IMAGE:
                return new UMC_ImageSql();
            case UMC_AttachmentType::ALL:
            case UMC_AttachmentType::REGULAR:
            default:
                return new UMC_AttachmentSql();
        }
    }


}
