<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\EventLocalisation;
use Doctrine\DBAL\Connection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

class EventLocalisationRepository extends ServiceEntityRepository
{
    private $entityManager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, EventLocalisation::class);
        $this->entityManager = $entityManager;
    }

    public function getCreatedEventId(
        string $place,
        string $description,
        string $address,
        string $email,
        string $dateFrom,
        string $dateTo,
        string $createdAt
    ):int
    {
        $qb = $this->createQueryBuilder('e')
            ->select('e.id')
            ->where('e.place = :place')
            ->andWhere('e.description = :description')
            ->andWhere('e.address = :address')
            ->andWhere('e.email = :email')
            ->andWhere('e.date_from = :dateFrom')
            ->andWhere('e.date_to = :dateTo')
            ->andWhere('e.created_at = :createdAt')
            ->setParameter('place', $place)
            ->setParameter('description', $description)
            ->setParameter('address', $address)
            ->setParameter('email', $email)
            ->setParameter('dateFrom', $dateFrom)
            ->setParameter('dateTo', $dateTo)
            ->setParameter('createdAt', $createdAt);
        $query = $qb->getQuery();
        $data = $query->getResult();
        return $data[0]['id'];
    }

    public function getData(): array
    {
        $qb = $this->createQueryBuilder('e')
            ->select('e.id AS id,
                            e.place AS place,
                            e.address AS address');
        $query = $qb->getQuery();
        $data = $query->getResult();
        return $data;
    }

    public function getDataByQuery(string $queryString): array
    {
        $qb = $this->createQueryBuilder('e')
            ->select('e.id AS id,
                            e.place AS place,
                            e.address AS address')
            ->where('UPPER(e.address) LIKE :queryString')
            ->setParameter('queryString', '%'.$queryString.'%');
        $query = $qb->getQuery();
        $data = $query->getResult();
        return $data;
    }

    public function getDetailDataById(int $id): array
    {
        $qb = $this->createQueryBuilder('e')
            ->select('e.id AS id,
                            e.place AS place,
                            e.description AS description,
                            e.address AS address,
                            e.email AS email,
                            e.date_from AS dateFrom,
                            e.date_to AS dateTo,
                            e.created_at AS createdAt,
                            e.lat AS lat,
                            e.lng AS lng')
            ->where('e.id = :id')
            ->setParameter('id', $id);
        $query = $qb->getQuery();
        $data = $query->getResult();
        return $data[0];
    }
}
