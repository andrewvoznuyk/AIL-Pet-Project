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
    public function SendMailFunc($user,$location,$aircraft){

        $email = (new TemplatedEmail())
            ->from('no-reply@ail.com')
            ->to($user['email'])
            ->subject('Your ticket!')
            ->htmlTemplate('mailTemplate.twig')
            ->context([
                'email'=>$user['email'],
                'from'=>$location['from'],
                'to'=>$location['to'],
                'arrival'=>$location['arrival'],
                'departure'=>$location['departure'],
                'place'=>$aircraft['place'],
                'aircraftModel'=>$aircraft['model'],
                'aircraftNumber'=>$aircraft['number'],
                'name'=>$user['name'],
                'surName'=>$user['surName'],
            ]);

        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            $e->getMessage();
        }
    }
}