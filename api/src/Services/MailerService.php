<?php

namespace App\Services;

use Dompdf\Dompdf;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;

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

    /**
     * @param $user
     * @param $location
     * @param $aircraft
     * @return void
     */
    public function SendMailFunc($user, $location, $aircraft):void
    {

        $email = (new TemplatedEmail())
            ->from('no-reply@ail.com')
            ->to($user['userEmail'])
            ->subject('Your ticket!')
            ->htmlTemplate('mailTemplate.twig')
            ->context([
                'from' => $location['from'],
                'to' => $location['to'],
                'arrival' => $location['arrival'],
                'departure' => $location['departure'],
                'place' => $aircraft['place'],
                'aircraftModel' => $aircraft['model'],
                'aircraftNumber' => $aircraft['number'],
                'name' => $user['name'],
                'surName' => $user['surName'],
                'companyName' => $aircraft['companyName']
            ]);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($email->getHtmlBody());
        $dompdf->render();
        $output = $dompdf->output();

        $email->attach($output, 'ticket.pdf');

        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            $e->getMessage();
        }
    }
}