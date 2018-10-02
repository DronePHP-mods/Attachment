<?php

namespace Attachment\Model;

use Drone\Db\Entity;

class Attachment extends Entity
{
	/**
	 * @var integer
	 */
    public $ATTACHMENT_TYPE;

	/**
	 * @var integer
	 */
    public $SEQUENTIAL;

	/**
	 * @var string
	 */
    public $ATTACHMENT_NAME;

	/**
	 * @var string
	 */
    public $ANNUL_DESCRIPTION;

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
        $this->setTableName("DPM_ATTACHMENT");
	}
}