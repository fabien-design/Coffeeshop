<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * @return Product[] Returns an array of Product objects
     */
    public function findByFilters(array $filters): array
    {
        $conditions = [];
        $params = [];

        if ($filters['categories'] !== "aucun") {
            $conditions[] = 'p.category = :categ';
            $params['categ'] = $filters['categories'];
        }

        if ($filters['brand'] !== "aucun") {
            $conditions[] = 'p.brand = :brand';
            $params['brand'] = $filters['brand'];
        }

        if ($filters['family'] !== "aucun") {
            $conditions[] = 'p.family = :family';
            $params['family'] = $filters['family'];
        }

        $queryBuilder = $this->createQueryBuilder('p');

        if (!empty($conditions)) {
            foreach ($conditions as $cond) {
                $queryBuilder->andWhere($cond);
            }
        }

        if (!empty($params)) {
            foreach ($params as $key => $value) {
                $queryBuilder->setParameter($key, $value);
            }
        }


        $queryBuilder
            ->orderBy('p.id', 'ASC');

        return $queryBuilder->getQuery()->getResult();
    }

    public function findByFiltersPagination(array $filters, int $limit, int $offset): array
    {
        $conditions = [];
        $params = [];

        if ($filters['categories'] !== "aucun") {
            $conditions[] = 'p.category = :categ';
            $params['categ'] = $filters['categories'];
        }

        if ($filters['brand'] !== "aucun") {
            $conditions[] = 'p.brand = :brand';
            $params['brand'] = $filters['brand'];
        }

        if ($filters['family'] !== "aucun") {
            $conditions[] = 'p.family = :family';
            $params['family'] = $filters['family'];
        }

        $queryBuilder = $this->createQueryBuilder('p');

        if (!empty($conditions)) {
            foreach ($conditions as $cond) {
                $queryBuilder->andWhere($cond);
            }
        }

        if (!empty($params)) {
            foreach ($params as $key => $value) {
                $queryBuilder->setParameter($key, $value);
            }
        }

        $queryBuilder
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->orderBy('p.id', 'ASC');

        return $queryBuilder->getQuery()->getResult();
    }

   
    public function findWithPagination(int $limit, int $offset): array
    {

        $queryBuilder = $this->createQueryBuilder('p');

        $queryBuilder->setFirstResult($offset);
        $queryBuilder->setMaxResults($limit);
        $queryBuilder->orderBy('p.id', 'ASC');

        return $queryBuilder->getQuery()->getResult();
    }

}
