<?php

namespace App\Repository;

use App\Entity\Advertisement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Advertisement>
 *
 * @method Advertisement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Advertisement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Advertisement[]    findAll()
 * @method Advertisement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdvertisementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Advertisement::class);
    }

    public function getFiveLatestAd()
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery('SELECT ad FROM App\Entity\Advertisement ad');
        $query->setMaxResults(15);
        $advertisements = $query->getResult();
        return $advertisements;
    }
    public function getAdByLocation(string $location)
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery('SELECT ad FROM App\Entity\Advertisement ad WHERE ad.location = ?1')->setParameter('1', $location);
        $advertisements = $query->getResult();
        return $advertisements;
    }
    public function getAdByContract(string $contract)
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery('SELECT ad FROM App\Entity\Advertisement ad WHERE ad.contract = ?1')->setParameter('1', $contract);
        $advertisements = $query->getResult();
        return $advertisements;
    }

    public function getAdByTitle(string $search)
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery("SELECT ad FROM App\Entity\Advertisement ad WHERE ad.title LIKE '%".$search."%'");
        $advertisements = $query->getResult();
        return $advertisements;
        
    }

    public function getNbAd()
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery('SELECT COUNT(ad) FROM App\Entity\Advertisement ad');
        $advertisements = $query->getResult();
        return $advertisements;
    }
    

//    /**
//     * @return Advertisement[] Returns an array of Advertisement objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Advertisement
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
