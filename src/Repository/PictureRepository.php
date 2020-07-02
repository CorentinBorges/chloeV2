<?php

namespace App\Repository;

use App\Entity\Picture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Picture|null find($id, $lockMode = null, $lockVersion = null)
 * @method Picture|null findOneBy(array $criteria, array $orderBy = null)
 * @method Picture[]    findAll()
 * @method Picture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PictureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Picture::class);
    }

    /**
     * @return Picture[] Returns an array of Picture objects
     */
    public function findNotNull(?string $attribute)
    {
        return $this->createQueryBuilder('p')
            ->andWhere("p.".$attribute." IS NOT NULL")
            ->orderBy("p.".$attribute, 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function count($category=null)
    {

           $result= $this->createQueryBuilder('p')
                    ->select('count(p.id)');
            if ($category) {
                $result->andWhere("p." . $category . " IS NOT NULL");
            }
            return $result ->getQuery()
                            ->getSingleScalarResult();



        /*return $this->createQueryBuilder('p.id')
            ->select('COUNT(p)')
            ->getQuery()
            ->getSingleScalarResult();*/
    }






    // /**
    //  * @return Picture[] Returns an array of Picture objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Picture
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
