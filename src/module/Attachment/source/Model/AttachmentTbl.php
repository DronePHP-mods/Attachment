<?php

namespace Attachment\Model;

use Drone\Db\TableGateway\TableGateway;

class AttachmentTbl extends TableGateway
{
    /**
     * Return the next sequential for an attachment type
     *
     * @param integer $type
     *
     * @return string
     */
    public function nextSequential($type)
    {
        $sql = "SELECT NVL(MAX(SEQUENTIAL),0) + 1 FROM DPM_ATTACHMENT WHERE ATTACHMENT_TYPE = $type";

        $this->getDriver()->getDb()->execute($sql);
        $row = $this->getDriver()->getDb()->getArrayResult();

        return $row[0][0];
    }
}