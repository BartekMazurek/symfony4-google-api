<?php

declare(strict_types=1);


namespace App\Service;

use App\Entity\EventLocalisation;
use App\Event\GeolocationCreatedEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class LocalisationService
{
    private $entityManager;
    private $googleLocationAdapter;
    private $eventDispatcher;

    public function __construct(EntityManagerInterface $entityManager, GoogleLocationAdapter $googleLocationAdapter, EventDispatcherInterface $eventDispatcher)
    {
        $this->entityManager = $entityManager;
        $this->googleLocationAdapter = $googleLocationAdapter;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function handle(EventLocalisation $eventLocalisation): void
    {
        $this->googleLocationAdapter->locatePlace($eventLocalisation->getAddress());

        $eventLocalisation->setLat($this->googleLocationAdapter->getLat());
        $eventLocalisation->setLng($this->googleLocationAdapter->getLng());
        $eventLocalisation->setCreatedAt(new \DateTime());

        $this->entityManager->persist($eventLocalisation);
        $this->entityManager->flush();

        $geolocationCreatedEvent = new GeolocationCreatedEvent($eventLocalisation);
        $this->eventDispatcher->dispatch($geolocationCreatedEvent, GeolocationCreatedEvent::NAME);
    }
}
