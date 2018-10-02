<?php

if (!function_exists('ifdef'))
{
	function ifdef($value, Array $array)
	{
		$global = __DIR__  . '/../../../config/global.config.php';

		if (file_exists($global))
		{
			$key = array_shift($array);
			$in  = include $global;

			do
			{
				if (is_array($in))
				{
					if (array_key_exists($key, $in))
						$in = $in[$key];
					else
						return $value;
				}
				else
					return $value;

				$key = ($array) ? array_shift($array) : NULL;

				if (!$key)
					return $in;

			} while($key);
		}
		else
			return $value;
	}
}

return [
	"authentication" => [
		"method"  => ifdef('_COOKIE', ["authentication", "method"]),		# the method to store credentials (_COOKIE, _SESSION)
		"key"     => ifdef('session_id', ["authentication", "key"]),		# the key in the array to store credentials
        /** AUTH TYPE:
         * db_table: get credentials from a table in a database
         * db_user:  get credentials from database users (database authentication)
         */
		"type"    => "db_table",
        /** DB GATEWAY:
         * Gateway is used to connect to database. It consists in an entity that connects to
         * a database and checks the specified credentials. Theses will checked only if the AUTH TYPE is db_table.
         */
		"gateway" => [
			"entity" => "USER",			# Table name (without prefix if exists)
	        /** CREDENTIALS:
	         * The field names of credentials in the table.
	         */
			"credentials" => [
				"username" => "USERNAME",
				"password" => "USER_PASSWORD"
			],

			// [TO DO] - Add validations for the following ...


	        /** TABLE INFO:
	         * Other information may be required for abstraction. If mail_checking is not enabled, your must define
	         * at least the id_field for the table.
	         */
			"table_info" => [
				"columns" => [
					"id_field"    => "USER_ID",				# often the primary key
					"state_field" => "USER_STATE_ID",		# required if mail_checking is enabled
					"email_field" => "EMAIL"				# required registration process
				],
				"column_values" => [
					"state_field" => [
						"pending_email" => 1,				# required if mail_checking is enabled
						"user_active"   => 2,				# required if mail_checking is enabled
					]
				]
			]
		],
	],
];