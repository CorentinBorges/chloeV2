<?php


namespace App\Repository;


abstract class BaseRepository extends \Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository
{
    public function maxId(string $entity)
    {

        return $this->createQueryBuilder('w')
            ->select('MAX(p.id)')
            ->from($entity,'p')
            ->getQuery()
            ->getSingleScalarResult()
            ;
    }
}