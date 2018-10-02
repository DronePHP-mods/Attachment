<?php

namespace Attachment\Model;

use Drone\Db\TableGateway\TableGateway;

class AttachmentTypeTbl extends TableGateway
{
    /**
     * Returns active attachment types by archetype
     *
     * @param integer $archetype
     *
     * @return array
     */
    public function fetch($archetype)
    {
        return $this->select(array("STATE" => 'A', 'ARCHETYPE_ID' => $archetype));
    }

    /**
     * Returns active and required attachment types by archetype
     *
     * @param integer $archetype
     *
     * @return array
     */
    public function fetchAllRequired($archetype)
    {
        return $this->select(array("STATE" => 'A', "REQUIRED" => 'S', 'ARCHETYPE_ID' => $archetype));
    }

    /**
     * Returns the attachment type by id
     *
     * @param integer $type
     *
     * @return Attachment\Model\AttachmentType
     */
    public function getAttachmentTypeById($type)
    {
        $result = $this->select(array(
            "ATTACHMENT_TYPE" => $type
        ));

        if (!count($result))
            throw new \Exception("The attachment type '$type' does not exists");

        $filtered_array = array();

        foreach ($result[0] as $key => $value)
        {
            if (is_string($key))
                $filtered_array[$key] = $value;
        }

        $type = new AttachmentType();
        $type->exchangeArray($filtered_array);

        return $type;
    }
}