<?php

namespace Attachment\Model;

use Drone\Db\Entity;

class AttachmentType extends Entity
{
	/**
	 * @var integer
	 */
    public $ATTACHMENT_TYPE;

	/**
	 * @var integer
	 */
    public $ARCHETYPE_ID;

	/**
	 * @var string
	 */
    public $DESCRIPTION;

	/**
	 * @var string
	 */
    public $STATE;

	/**
	 * @var string
	 */
    public $REQUIRED;

	/**
	 * @var date
	 */
    public $RECORD_DATE;

    public function __construct($data = [])
    {
    	parent::__construct($data);
        $this->setTableName("DPM_ATTACHMENT_TYPE");
    }
}