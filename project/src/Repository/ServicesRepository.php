<?php

namespace App\Repository;

use App\Entity\Services;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @method Services|null find($id, $lockMode = null, $lockVersion = null)
 * @method Services|null findOneBy(array $criteria, array $orderBy = null)
 * @method Services[]    findAll()
 * @method Services[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServicesRepository extends ServiceEntityRepository
{

    /**
     * @var EntityManagerInterface
     */
    protected $em;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface  $em)
    {
        parent::__construct($registry, Services::class);
        $this->em = $em;
    }

     /**
      * @return Services[] Returns an array of Services objects
      */

    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }



    public function findOneBySomeField($value): ?Services
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }


    public function findLikeName($name)
    {
        return $this
            ->createQueryBuilder('a')
            ->where('a.name LIKE :name')
            ->setParameter( 'name', "%$name%")
            ->orderBy('a.name')
            ->setMaxResults(5)
            ->getQuery()
            ->execute()
            ;
    }

}
