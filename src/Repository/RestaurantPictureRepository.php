<?php

namespace App\Repository;

use App\Entity\RestaurantPicture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RestaurantPicture>
 *
 * @method RestaurantPicture|null find($id, $lockMode = null, $lockVersion = null)
 * @method RestaurantPicture|null findOneBy(array $criteria, array $orderBy = null)
 * @method RestaurantPicture[]    findAll()
 * @method RestaurantPicture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RestaurantPictureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RestaurantPicture::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(RestaurantPicture $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(RestaurantPicture $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return RestaurantPicture[] Returns an array of RestaurantPicture objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RestaurantPicture
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
