<?php


namespace App\Repository;


use App\Pagination\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use App\Entity\Producto;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

class ProductoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Producto::class);
    }

    public function getLatest()
    {
        $query = $this->createQueryBuilder('p')
            ->orderBy('p.fechaSalida','DESC')
            ->getQuery()
            ->setMaxResults(1);

            return $query->getResult();
    }

    public function getAll(int $page=1){
        $query = $this->createQueryBuilder('producto');

        return (new Paginator($query))->paginate($page);
    }
}