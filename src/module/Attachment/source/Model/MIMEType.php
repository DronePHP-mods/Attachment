<?php

namespace Attachment\Model;

use Drone\Db\Entity;

class MIMEType extends Entity
{
	/**
	 * @var integer
	 */
    public $MIME_ID;

	/**
	 * @var string
	 */
    public $MIME_TYPE;

	/**
	 * @var string
	 */
    public $DESCRIPTION;

	/**
	 * @var string
	 */
    public $EXTENSIONS;

    public function __construct($data = [])
    {
    	parent::__construct($data);
        $this->setTableName("DPM_MIME_TYPE");
    }
}