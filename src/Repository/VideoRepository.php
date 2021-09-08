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


    public function videoByStudio($slug, $id)
    {
        return $this->createQueryBuilder('v')
            ->select('v')
            ->leftJoin('v.studio','s')
            //attention la syntaxe doit etre comme celle ci dans le where dans espace =:
            ->where('s.slugName=:slug')
            ->setParameter('slug', $slug)
            ->andWhere('v.id=:id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }

}
