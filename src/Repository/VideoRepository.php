<?php

namespace App\Repository;

use App\Entity\Video;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Video|null find($id, $lockMode = null, $lockVersion = null)
 * @method Video|null findOneBy(array $criteria, array $orderBy = null)
 * @method Video[]    findAll()
 * @method Video[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VideoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Video::class);
    }

    public function datePublished()
    {
        return $this->createQueryBuilder('v')
            ->Select('v.programmingDate')
            ->getQuery()
            ->getResult();
    }


//    //requete pour recuperer a la vue que les status
//    public function statusPublished()
//    {
//        return $this->createQueryBuilder('v')
//            ->select('v')
//            ->leftJoin('v.status','s')
//            ->addSelect('s.name')
//            ->getQuery()
//            ->getResult();
//    }

}
