<?php

namespace App\Repository;

use App\Entity\WebsiteInfos;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method WebsiteInfos|null find($id, $lockMode = null, $lockVersion = null)
 * @method WebsiteInfos|null findOneBy(array $criteria, array $orderBy = null)
 * @method WebsiteInfos[]    findAll()
 * @method WebsiteInfos[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WebsiteInfosRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WebsiteInfos::class);
    }


    /*
    public function findOneBySomeField($value): ?WebsiteInfos
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
