<?php

namespace AppBundle\Service;

use Swift_Mailer;
use Swift_Message;

class InquiryService
{
    /**
     * @var Swift_Mailer
     */
    private $mailer;

    /**
     * @param Swift_Mailer $mailer
     */
    public function __construct(Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @param array $inquire
     */
    public function sendEmail(array $inquire)
    {
        $message = Swift_Message::newInstance()
            ->setSubject('vPit inquire')
            ->setFrom($inquire['email'])
            ->setBody($inquire['message']);

        $this->mailer->send($message);
    }
}
