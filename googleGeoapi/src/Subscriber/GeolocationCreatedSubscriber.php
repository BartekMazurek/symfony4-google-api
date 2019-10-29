<?php

declare(strict_types=1);


namespace App\Subscriber;

use App\Event\GeolocationCreatedEvent;
use App\Repository\EventLocalisationRepository;
use App\Service\MailNotificationService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class GeolocationCreatedSubscriber implements EventSubscriberInterface
{
    private $eventLocalisationRepository;
    private $mailNotificationService;

    public function __construct(EventLocalisationRepository $eventLocalisationRepository, MailNotificationService $mailNotificationService)
    {
        $this->eventLocalisationRepository = $eventLocalisationRepository;
        $this->mailNotificationService = $mailNotificationService;
    }

    public static function getSubscribedEvents()
    {
        return [
            GeolocationCreatedEvent::NAME => 'geoLocationCreatedEvent'
        ];
    }

    public function geoLocationCreatedEvent(GeolocationCreatedEvent $event)
    {
        $eventId = $this->eventLocalisationRepository->getCreatedEventId(
            $event->getPlace(),
            $event->getDescription(),
            $event->getAddress(),
            $event->getEmail(),
            $event->getDateFrom(),
            $event->getDateTo(),
            $event->getCreatedAt()
        );

        $this->mailNotificationService->notify(
            $eventId,
            $event->getPlace()
        );
    }
}
