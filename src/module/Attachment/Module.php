<?php

namespace Attachment;

Use Drone\Mvc\AbstractionModule;
use Drone\Mvc\AbstractionController;

class Module extends AbstractionModule
{
	public function init(AbstractionController $c)
	{
		$this->runAuthentication($c);
	}

    /**
     * Checks if the user is logged and redirects if isn't
     *
     * @return string|null
     */
    private function runAuthentication(AbstractionController $c)
    {
        $config = include 'module/Attachment/config/user.config.php';
        $method = $config["authentication"]["method"];
        $key    = $config["authentication"]["key"];

        switch ($method)
        {
            case '_COOKIE':

                if (!(array_key_exists($key, $_COOKIE) || !empty($_COOKIE[$key])))
                {
                    if (array_key_exists("CR_VAR_URL_REJECTED", $_SESSION) || !empty($_SESSION["CR_VAR_URL_REJECTED"]))
                        header("location: " . $_SESSION["CR_VAR_URL_REJECTED"]);
                    else
                        header("location: " . $c->basePath . "/public/Auth");
                }

                break;

            case '_SESSION':

                if (!(array_key_exists($key, $_SESSION) || !empty($_SESSION[$key])))
                {
                    if (array_key_exists("CR_VAR_URL_REJECTED", $_SESSION) || !empty($_SESSION["CR_VAR_URL_REJECTED"]))
                        header("location: " . $_SESSION["CR_VAR_URL_REJECTED"]);
                    else
                        header("location: " . $c->basePath . "/public/Auth");
                }

                break;
        }
    }
}