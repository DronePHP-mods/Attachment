<?php

namespace Attachment\Model;

use Drone\Db\Entity;

class AttachmentMIMEType extends Entity
{
	/**
	 * @var integer
	 */
    public $ATTACHMENT_TYPE;

	/**
	 * @var integer
	 */
    public $MIME_ID;

	/**
	 * @var string
	 */
    public $STATE;

	/**
	 * @var date
	 */
    public $RECORD_DATE;

    public function __construct($data = [])
    {
    	parent::__construct($data);
        $this->setTableName("DPM_ATTACHMENT_MIME_TYPE");
    }
}