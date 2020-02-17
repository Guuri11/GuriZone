<?php


namespace App\Repository;


use App\Pagination\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use App\Entity\Producto;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use DateTime;
use function Symfony\Component\String\b;

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

    public function getAll(int $page = 1, string $search = null, string $category = null, DateTime $startDate = null, DateTime $endDate = null):Paginator{
        $query = $this->createQueryBuilder('p')
        ->orderBy('p.idProd','DESC');
        if ($search !== null){
            $query
                ->where('p.modeloProd LIKE :search')
                ->orWhere('p.categoriaProd LIKE :search')
                ->orWhere('p.subcategoriaProd LIKE :search')
                ->orWhere('p.marcaProd LIKE :searc')
                ->setParameter('search','%'.$search.'%');
        }
        if ($category !== null && $category !=='todo'){
            $category = strtolower($category);
            switch ($category){
                case 'accesorios': $category = '1';break;
                case 'ropa': $category = '2';break;
                case 'zapatillas': $category = 3;break;
                default:
            }
            $query
                ->andWhere('p.categoriaProd = :category')
                ->setParameter('category',$category);
        }
        if ($startDate !== null){
            $query->andWhere('p.fechaSalida >= :startDate')
                ->orderBy('p.idProd',' ASC')
                ->setParameter('startDate',$startDate->format('Y-m-d H:i:s'));
        }
        if ($endDate !== null){
            $query->andWhere('p.fechaSalida <= :endDate')
                ->setParameter('endDate',$endDate->format('Y-m-d H:i:s'));

        }

        return (new Paginator($query))->paginate($page);
    }
}