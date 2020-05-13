<?php

namespace App\Repository;

use App\Entity\Geolocalizacion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Geolocalizacion|null find($id, $lockMode = null, $lockVersion = null)
 * @method Geolocalizacion|null findOneBy(array $criteria, array $orderBy = null)
 * @method Geolocalizacion[]    findAll()
 * @method Geolocalizacion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GeolocalizacionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Geolocalizacion::class);
    }

    // /**
    //  * @return Geolocalizacion[] Returns an array of Geolocalizacion objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */


    public function findOneByCodigoIsoPais($codigoIsoPais): ?Geolocalizacion
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.codigoISOPais = :val')
            ->setParameter('val', $codigoIsoPais)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function obtenerGeolocalizacionMaximaDistancia(): ?Geolocalizacion{
        return $this->createQueryBuilder('g')
            ->orderBy('g.distanciaDesdeBsAs', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function obtenerGeolocalizacionMinimaDistancia(): ?Geolocalizacion{
        return $this->createQueryBuilder('g')
            ->orderBy('g.distanciaDesdeBsAs', 'ASC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

}
