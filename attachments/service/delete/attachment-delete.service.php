<?php


class UMC_AttachmentDeleteService
{
    public $directoryService;

    public function __construct()
    {
        $this->directoryService = new UMC_DirectoryService();
    }


    public function delete(UMC_Attachment $attachment)
    {
        $deleted = wp_delete_attachment($attachment->id) !== false;
        $attachmentDelete = new UMC_AttachmentDelete();
        $attachmentDelete->attachment = $attachment;
        $attachmentDelete->erased = $deleted;
        return $attachmentDelete;
    }

    public function deleteWithoutId(UMC_Attachment $attachment)
    {
        $attachmentDelete = new UMC_AttachmentDelete();
        $attachmentDelete->attachment = $attachment;
        $attachmentDelete->erased = $this->directoryService->delete($attachment->src);
        return $attachmentDelete;
    }

    public function deleteChild(UMC_Image $image)
    {
        $attachmentWP = wp_get_attachment_metadata($image->id);

        $sizeName = $image->sizeName;

        $attachmentDelete = new UMC_AttachmentDelete();
        $attachmentDelete->attachment = $image;

        // do nothing
        if(empty($sizeName)) {
            return $attachmentDelete;
        }

        clearstatcache();
        if (!file_exists($image->src)) {

            unset($attachmentWP["sizes"][$sizeName]);
            wp_update_attachment_metadata($image->id, $attachmentWP);
            $attachmentDelete->erased = true;
        } else {

            if ($this->directoryService->delete($image->src)) {

                clearstatcache();

                if (!file_exists($image->src)) {
                    unset($attachmentWP["sizes"][$sizeName]);
                    wp_update_attachment_metadata($image->id, $attachmentWP);
                    $attachmentDelete ->erased = true;
                }
            }
        }
        return $attachmentDelete;
    }



}
