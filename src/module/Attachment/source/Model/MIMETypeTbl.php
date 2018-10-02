<?php

namespace Attachment\Model;

use Drone\Db\TableGateway\TableGateway;

class MIMETypeTbl extends TableGateway
{
    /**
     * Returns all data from the table
     *
     * @return array
     */
    public function fetch()
    {
        return $this->select();
    }

    /**
     * Returns the mime type by id
     *
     * @param integer $id_mime
     *
     * @return Attachment\Model\MIMEType
     */
    public function getMIMEById($id_mime)
    {
        $result = $this->select([
            "MIME_ID" => $id_mime
        ]);

        if (!count($result))
            throw new \Exception("MIME type '$id_mime' does not exists");

        $filtered_array = array();

        foreach ($result[0] as $key => $value)
        {
            if (is_string($key))
                $filtered_array[$key] = $value;
        }

        $mimeType = new MIMEType();
        $mimeType->exchangeArray($filtered_array);

        return $mimeType;
    }
}