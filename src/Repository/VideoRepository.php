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

    function ConvertisseurTime($Time){
        if($Time < 3600){
            $heures = 0;

            if($Time < 60){$minutes = 0;}
            else{$minutes = round($Time / 60);}

            $secondes = floor($Time % 60);
        }
        else{
            $heures = round($Time / 3600);
            $secondes = round($Time % 3600);
            $minutes = floor($secondes / 60);
        }

        $secondes2 = round($secondes % 60);

        $TimeFinal = "$heures h $minutes min $secondes2 s";
        return $TimeFinal;
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
