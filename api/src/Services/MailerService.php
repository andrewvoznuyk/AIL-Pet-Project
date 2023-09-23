<?php

namespace App\Services;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailerService
{
    /**
     * @var MailerInterface
     */
    private MailerInterface $mailer;

    /**
     * @param MailerInterface $mailer
     */
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }
    public function SendMailFunc($from,$to,$date,$aircraft){

        $email = (new TemplatedEmail())
            ->from('mr.kolyakonoval@gmail.com')
            ->to('you@example.com')
            ->subject('Тест відправки листа!')
            ->text('Коля відправив тестовий лист!')
            ->htmlTemplate('mailTemplate.twig')
            ->context([
                'from'=>$from,
                'to'=>$to,
                'date'=>$date,
                'aircraft'=>$aircraft
            ]);

        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {

        }
    }
}