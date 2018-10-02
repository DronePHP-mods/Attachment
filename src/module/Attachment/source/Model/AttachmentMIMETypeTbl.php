<?php

namespace Attachment\Model;

use Drone\Db\TableGateway\TableGateway;

class AttachmentMIMETypeTbl extends TableGateway
{
    /**
     * Returns the attachment mime type by key
     *
     * @param array $mime_id
     * @param array $attachment_type
     *
     * @return Attachment\Model\AttachmentMIMEType
     */
    public function getAttachmentMIMETypeByKey($mime_id, $attachment_type)
    {
        $result = $this->select(array(
            "MIME_ID"         => $mime_id,
            "ATTACHMENT_TYPE" => $attachment_type,
        ));

        if (!count($result))
            throw new \Exception("The mime type '$mime_id' does not exists for the attachment type '$attachment_type'");

        $filtered_array = array();

        foreach ($result[0] as $key => $value)
        {
            if (is_string($key))
                $filtered_array[$key] = $value;
        }

        $attachmentMimeType = new AttachmentMIMEType();
        $attachmentMimeType->exchangeArray($filtered_array);

        return $attachmentMimeType;
    }

    /**
     * Returns all valid mime types by attachment type
     *
     * @param Attachment\Model\AttachmentType|integer $attachment_type
     *
     * @return array
     */
    public function getMIMEByAttachmentType($attachment_type)
    {
        if ($attachment_type instanceof AttachmentType)
            $id = $attachment_type->ATTACHMENT_TYPE;
        else if (is_integer($attachment_type))
            $id = $attachment_type;
        else
            throw new \Exception("Invalid type given. Integer or Attachment\Model\AttachmentType expected");

        $sql = "SELECT A.ATTACHMENT_TYPE, A.MIME_ID, TIPO_MIME, DESCRIPTION, A.STATE
                FROM DPM_ATTACHMENT_MIME_TYPE A
                INNER JOIN DPM_MIME_TYPE B ON A.MIME_ID = B.MIME_ID
                WHERE A.ATTACHMENT_TYPE = $id";

        $this->getDriver()->getDb()->execute($sql);
        return $this->getDriver()->getDb()->getArrayResult();
    }
}