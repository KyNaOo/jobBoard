<?php

namespace App\Repository;

use App\Entity\Postulate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Postulate>
 *
 * @method Postulate|null find($id, $lockMode = null, $lockVersion = null)
 * @method Postulate|null findOneBy(array $criteria, array $orderBy = null)
 * @method Postulate[]    findAll()
 * @method Postulate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostulateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Postulate::class);
    }

    public function getPosByUser(int $idUser)
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery('SELECT po FROM App\Entity\Postulate po WHERE po.userId = ?1')->setParameter('1', $idUser);
        $postulates = $query->getResult();
        return $postulates;
    }
    //Pour ajouter une candidature : persist suivi de flush : $entityManager->persist($postulate) et suivi de $entityManager->flush()

//    /**
//     * @return Postulate[] Returns an array of Postulate objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Postulate
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
