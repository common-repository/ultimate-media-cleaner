<?php

class UMC_DirectoryService
{

    public function __construct()
    {

    }

    public function mimeType($path)
    {
        $mime = null;
        if (file_exists($path)) {
            $mime = mime_content_type($path);
        }
        return UMC_AttachmentType::typeFromMime($mime);
    }

    public function filePath($directory, $name)
    {

        return $this->concatAndTreatExtraSlash($this->directoryPath($directory), basename($name));
    }

    public function directoryPath($directory)
    {

        return trailingslashit($this->concatAndTreatExtraSlash(UMC_WP_UPLOAD_PATH, $directory));
    }

    private function concatAndTreatExtraSlash($a, $b)
    {

        if (substr($a, -1) == "/" && substr($b, 0, 1) == "/") {
            return $a . substr($b, 1, strlen($b));
        }

        if (substr($a, -1) != "/" && substr($b, 0, 1) != "/") {
            return $a . '/' . $b;
        }

        return $a . $b;
    }

    public function fileUrl($directory, $name)
    {
        $base = $this->concatAndTreatExtraSlash(UMC_WP_UPLOAD_URL, $directory);
        // see at https://core.trac.wordpress.org/browser/tags/4.8/src/wp-includes/post.php#L5029
        return $this->concatAndTreatExtraSlash($base, basename($name));
    }

    private function getSimpleFilesFromDirectory($directory, $addUploadDir = true)
    {

        $wpDirectory = $directory;

        if ($addUploadDir) {
            $wpDirectory = UMC_WP_UPLOAD_PATH . $directory;
        }

        $files = array_diff(scandir($wpDirectory), array('.', '..'));

        $directoryFiles = new UMC_DirectoryFiles($directory, $files);

        return $directoryFiles;
    }

    public function getFilesFromDirectory($directory)
    {

        $directoryInServer = UMC_WP_UPLOAD_PATH . $directory;
        $dirIterator = new \DirectoryIterator($directoryInServer);

        $iter = new \IteratorIterator($dirIterator);

        $directoryFiles = new UMC_DirectoryFiles($directory);

        foreach ($iter as $iterFile) {

            if ($iterFile->isFile()) {

                $mime = $this->mimeType($iterFile->getPathname());
                $file = new UMC_Attachment();
                if ($mime == UMC_AttachmentType::IMAGE) {
                    $file = new UMC_Image();
                    // TODO: complete info H and W
                }

                $file->name = $iterFile->getFilename();
                $file->directory = $directory;
                $file->src = $this->filePath($directory, $file->name);
                $file->url = $this->fileUrl($directory, $file->name);
                $file->type = $this->mimeType($iterFile->getPathname());
                $file->size = $iterFile->getSize();
                $file->status = UMC_AttachmentStatus::UNKNOWN;
                $directoryFiles->addFile($file);
            }
        }
        return $directoryFiles;
    }

//    // TODO: to delete???
//    public function getFile($name, $directory)
//    {
//        $path = $this->filePath($directory, $name);
//
//        if (!file_exists($path)) {
//            return null;
//        }
//
//        $fileInfo = pathinfo($path);
//        $src = $fileInfo['dirname'] . '/' . $fileInfo['basename'];
//        $file = new UMC_Attachment();
//        $mime = $this->mimeType($file->src);
//        if ($mime == UMC_AttachmentType::IMAGE) {
//            $file = new UMC_Image();
//            // TODO: complete info H and W
//        }
//
//        $file->name = $fileInfo['basename'];
//        $file->directory = $directory;
//        $file->src = $src;
//        $file->url = $this->fileUrl($directoryInServer, $file->name);
//        $file->type = $mime;
//        $file->size = filesize($path);
//        $file->status = UMC_AttachmentStatus::UNKNOWN;
//        return $file;
//    }

    public function getDirectories($base)
    {

        $recursiveDir = new \RecursiveDirectoryIterator($base, \RecursiveDirectoryIterator::SKIP_DOTS);
        $iter = new \RecursiveIteratorIterator(
            $recursiveDir, \RecursiveIteratorIterator::SELF_FIRST, \RecursiveIteratorIterator::CATCH_GET_CHILD
        );

        $directory = new UMC_Directory($base);

        foreach ($iter as $path => $dir) {
            if ($dir->isDir()) {
                $directory->addDirectory(str_replace($base, "", $path));
            }
        }

        return $directory;
    }

    public function getDirectoriesFromDirectory($base)
    {

        $dirIterator = new \DirectoryIterator($base);

        $iter = new \IteratorIterator($dirIterator);

        $directory = new UMC_Directory($base);

        foreach ($iter as $file) {
            if (!$file->isFile() && !$file->isDot()) {
                $directory->addDirectory($file->getFilename());
            }
        }

        return $directory;
    }

    public function delete($src)
    {
        // trying to delete something that is not at the upload folder
        if (strstr($src, UMC_WP_UPLOAD_PATH) === false) {
            return false;
        }
        if (file_exists($src)) {
            if (is_dir($src)) {
                @rmdir($src);
            } else {
                @unlink($src);
            }
        }
        clearstatcache();
        return !file_exists($src);
    }

    public function deleteDirectory($path)
    {
        $isUploadFolder = strstr($path, UMC_WP_UPLOAD_PATH);
        if (file_exists($path) && ($isUploadFolder !== false)) {

            $directories = $this->getDirectoriesFromDirectory($path);

            if (count($directories->directories) > 0) {
                foreach ($directories->directories as $directory) {

                    $this->deleteDirectory($path);
                }
            } else {

                $files = $this->getSimpleFilesFromDirectory($path, false);

                if (count($files->files) > 0) {
                    foreach ($files->files as $file) {
                        $filePath = $path . '/' . $file;
                        $this->delete($filePath);
                    }
                }

                $this->delete($path);
            }
        }
    }

    public function fileSize($path)
    {
        $size = -1;
        if (file_exists($path)) {
            $size = filesize($path);
        }
        return $size;
    }


}
