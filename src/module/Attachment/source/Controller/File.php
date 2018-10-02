<?php

namespace Attachment\Controller;

use Drone\Mvc\AbstractionController;
use Drone\FileSystem\Shell;
use Exception;

class File extends AbstractionController
{
    /**
     * Stores files temporarily before registering
     *
     * The file will be stored in the folder cache/files
     * The folder's name will be registered with an arbitrary toke
     *
     * @return array
     */
    public function loadTempFile()
    {
        # data to send
        $data = [];

        $this->setTerminal(true);

        # TRY-CATCH-BLOCK
        try {

            if (!count($_FILES))
            {
                if (array_key_exists("php_errormsg", $GLOBALS))
                    throw new Exception($GLOBALS["php_errormsg"], 1);

                # Checks if the file exists, if it's it will be deleted
                if (array_key_exists('token', $_GET) && !empty($_GET["token"]))
                {
                    $token = $_GET["token"];

                    if (file_exists("cache/files/" . $token ."/". $_GET["type"]))
                    {
                        $shell = new Shell();
                        $_files = $shell->ls("cache/files/" . $token ."/". $_GET["type"]);

                        foreach ($_files as $value)
                        {
                            if (!in_array($value, array(".", "..")))
                                $shell->rm("cache/files/" . $token ."/". $_GET["type"] . "/" . $value);
                        }
                    }
                }

                throw new \Exception("No files selected!", 300);
            }

            if (!array_key_exists('token', $_GET) || empty($_GET["token"]))
                throw new \Exception("Invalid Token!", 1);

            $token = $_GET["token"];
            $accept = base64_decode($_GET["mime"]);

            if (!file_exists("cache/files/" . $token))
            {
                if (!@mkdir("cache/files/" . $token))
                {
                    if (array_key_exists('php_errormsg', $GLOBALS))
                        throw new Exception($GLOBALS["php_errormsg"], 1);
                    else
                        throw new Exception("Error creating directory to store files!");
                }
            }

            if (!file_exists("cache/files/" . $token))
            {
                if (!@mkdir("cache/files/" . $token))
                {
                    if (array_key_exists('php_errormsg', $GLOBALS))
                        throw new Exception($GLOBALS["php_errormsg"], 1);
                    else
                        throw new Exception("Error creating directory to store files!", 1);
                }
            }

            if (!file_exists("cache/files/" . $token ."/". $_GET["type"]))
            {
                if (!@mkdir("cache/files/" . $token ."/". $_GET["type"]))
                {
                    if (array_key_exists('php_errormsg', $GLOBALS))
                        throw new Exception($GLOBALS["php_errormsg"], 1);
                    else
                        throw new Exception("Error creating directory to store files!", 1);
                }
            }

            $shell = new Shell();
            $_files = $shell->ls("cache/files/" . $token ."/". $_GET["type"]);

            foreach ($_files as $value)
            {
                if (!in_array($value, array(".", "..")))
                    $shell->rm("cache/files/" . $token ."/". $_GET["type"] . "/" . $value);
            }

            $data["name"] = array();

            foreach ($_FILES as $file)
            {
                $bytes_uploaded_file = $file["size"];

                if (!in_array($file["type"], explode(",", $accept)))
                    throw new Exception("Invalid file type");

                if (!@copy($file["tmp_name"], "cache/files/" . $token ."/". $_GET["type"] ."/". $file["name"]))
                {
                    if (array_key_exists('php_errormsg', $GLOBALS))
                        throw new Exception($GLOBALS["php_errormsg"], 1);
                    else
                        throw new Exception("Error copying files!");
                }

                $data["name"][] = $file["name"];
            }

            if (count($data["name"]) == 1)
                $data["name"] = array_shift($data["name"]);

            # SUCCESS-MESSAGE
            $data["process"] = "success";
        }
        catch (\Exception $e) {

            # ERROR-MESSAGE
            $data["process"] = ($e->getCode() == 300) ? "warning" : "error";
            $data["message"] = $e->getMessage();

            return $data;
        }

        return $data;
    }
}