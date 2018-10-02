<?php

namespace Attachment\Controller;

use Drone\Mvc\AbstractionController;

class Http extends AbstractionController
{
    public function download()
    {
        $this->setTerminal(true);

        $file = $_GET["f"];
        $path = $_GET["p"];

        $file = basename(base64_decode(urldecode($file)));
        $path = base64_decode(urldecode($path));

        if (!in_array($path, array('attachment/somedir')))
            return array();

        $full_path = 'public/' . $path . "/" . $file;

        if (!file_exists($full_path))
        {
            $full_path = 'cache/' . $path . "/" . $file;
        }

        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . $file);
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($full_path));
        readfile($full_path);

        return array();
    }
}