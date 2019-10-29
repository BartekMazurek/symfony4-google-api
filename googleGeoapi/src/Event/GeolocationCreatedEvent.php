<?php

declare(strict_types=1);


namespace App\Event;

use App\Entity\EventLocalisation;
use Symfony\Contracts\EventDispatcher\Event;

class GeolocationCreatedEvent extends Event
{
    public const NAME = 'GeolocationCreatedEvent';

    private $place;
    private $description;
    private $address;
    private $email;
    private $dateFrom;
    private $dateTo;
    private $createdAt;

    public function __construct(EventLocalisation $eventLocalisation)
    {
        $this->place = $eventLocalisation->getPlace();
        $this->description = $eventLocalisation->getDescription();
        $this->address = $eventLocalisation->getAddress();
        $this->email = $eventLocalisation->getEmail();
        $this->dateFrom = $eventLocalisation->getDateFrom()->format('Y-m-d');
        $this->dateTo = $eventLocalisation->getDateTo()->format('Y-m-d');
        $this->createdAt = $eventLocalisation->getCreatedAt()->format('Y-m-d H:i:s');
    }

    public function getPlace(): ?string
    {
        return $this->place;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getDateFrom(): string
    {
        return $this->dateFrom;
    }

    public function getDateTo(): string
    {
        return $this->dateTo;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }
}
