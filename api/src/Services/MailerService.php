<?php

namespace App\Services;

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
    public function SendMailFunc(){
        $email = (new Email())
            ->from('mr.kolyakonoval@gmail.com')
            ->to('you@example.com')
            ->subject('Тест відправки листа!')
            ->text('Коля відправив тестовий лист!')
            ->html("<h1 style='color: #00bb00'>Відправка листа у вигляді html</h1>");
        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {

        }
    }
}