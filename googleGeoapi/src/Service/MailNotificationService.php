<?php

declare(strict_types=1);


namespace App\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;

class MailNotificationService
{
    private $mailer;
    private $templating;
    private $notificationTo;
    private $notificationFrom;

    public function __construct(ContainerInterface $container)
    {
        $this->mailer = $container->get('mailer');
        $this->templating = $container->get('twig');
        $this->notificationTo = $_ENV['MAIL_NOTIFICATION_TO'];
        $this->notificationFrom = $_ENV['MAIL_NOTIFICATION_FROM'];
    }

    public function notify(int $eventId, string $place): void
    {
        $message = (new \Swift_Message('New event'))
            ->setFrom($this->notificationFrom)
            ->setTo($this->notificationTo)
            ->setContentType('text/html')
            ->setBody(
                $this->templating->render(
                    'email/notification.html.twig',
                    [
                        'eventId' => $eventId,
                        'place' => $place
                    ]
                )
            )
        ;
        $this->mailer->send($message);
    }
}
