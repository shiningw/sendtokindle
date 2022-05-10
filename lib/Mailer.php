<?php

namespace OCA\SendtoKindle;

use OCP\Mail\IAttachment;
use OCP\Mail\IMailer;
use OCP\Mail\IMessage;

class Mailer
{
    protected IMailer $mailer;
    protected IMessage $message;
    protected IAttachment $attachment;
    public function __construct(?array $options = null)
    {
        $this->mailer = \OC::$server->getMailer();
        if ($options)
            $this->createMessage($options);
    }

    public function createMessage($options)
    {
        extract($options);
        $this->message =  $this->mailer->createMessage();
        $this->message->setSubject($subject);
        $this->message->setFrom([$from => $from]);
        $this->message->setTo([$recipient => $recipient]);
        $this->message->setHtmlBody($body);
        return $this;
    }
    public function attach(string $file)
    {
        $this->message->attach($this->mailer->createAttachmentFromPath($file)->setFilename(basename($file)));
        return $this;
    }
    public function send()
    {
        try {
            $this->mailer->send($this->message);
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            return ['status' => false, 'error' => $msg];
        }
        return ['status' => true, "message" => "success"];
    }
}
