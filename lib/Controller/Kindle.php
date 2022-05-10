<?php

namespace OCA\SendtoKindle\Controller;

use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\JSONResponse;
use OCP\IRequest;
use OCP\ILogger;
use OC\Files\Filesystem;
use OC_Util;
use OCA\SendtoKindle\Mailer;
use OCA\SendtoKindle\Helper;

class Kindle extends Controller
{
    public function __construct($AppName, ILogger $logger, IRequest $Request, $uid)
    {
        parent::__construct($AppName, $Request);
        $this->uid = $uid;
        $this->logger = $logger;
        $folder = $Request->getParam("dir", "/"); // isset($_POST['dir']) ? $_POST['dir'] : '/';
        $this->filename = $filename = $Request->getParam("file"); //$filename = (string) $_POST['file'];
        $this->folder = trim($folder, '/');
        $this->file = $folder . '/' . $filename;
        $this->mailer = new Mailer();
        $this->init();
    }

    protected function init()
    {
        OC_Util::setupFS();
        $this->email = Helper::getSettings("sendtokindle-senderemail");
        $this->to = Helper::getSettings('sendtokindle-amazon-email');
        if (!$this->email || !$this->to) {
            $msg = "no from or target email address is set";
            return new JSONResponse(['status' => false, 'error' => $msg]);
        }
    }
    public function send()
    {

        $file = $this->getAbsoluteFilePath();
        $resp = [];

        if (!file_exists($file)) {
            $msg = sprintf("%s does not exist on the server", $file);
            $this->logger->error($msg);
            return JSONResponse(['status' => false, 'error' => $msg]);
        } else {
            $mail = [
                'body' => "",
                'subject' => 'Send to Kindle',
                'from' => $this->email,
                'recipient' => $this->to,
            ];
            $resp = $this->mailer->createMessage($mail)->attach($file)->send();
        }

        return new JSONResponse($resp);
    }

    private function getAbsoluteFilePath()
    {
        return Filesystem::getLocalFile($this->file);
    }
}
