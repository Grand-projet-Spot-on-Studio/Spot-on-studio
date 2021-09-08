<?php

namespace App\Repository;

use App\Entity\Studio;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Studio|null find($id, $lockMode = null, $lockVersion = null)
 * @method Studio|null findOneBy(array $criteria, array $orderBy = null)
 * @method Studio[]    findAll()
 * @method Studio[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Studio::class);
    }

    public function selectByStudio($slug){
        return $this->createQueryBuilder('s')
            ->select('s')
            ->where('s.slugName=:slug')
            ->setParameter('slug', $slug)
            ->getQuery()
            ->getResult();
    }

//    //requete pour recuperer a la vue que les video
//    public function displayVideoPublished()
//    {
//        return $this->createQueryBuilder('s')
//            ->select('s')
//            ->leftJoin('s.status','st')
//            ->leftJoin('st.video', 'stv')
//            ->addSelect('st.name')
//            ->addSelect('stv')
//            ->where('')
//
//            ->where('m.name = :name')
//            ->setParameter('name', 'picture')
//            ->getQuery()
//            ->getResult();
//    }

}
