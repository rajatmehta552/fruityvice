<?php

namespace App\Repository;

use App\Entity\Fruit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Paginator;

/**
 * @method Fruit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Fruit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Fruit[]    findAll()
 * @method Fruit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FruitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fruit::class);
    }

    public function findAllPaginated($page = 1, $limit = 10)
    {
        $query = $this->createQueryBuilder('f')
            ->orderBy('f.name', 'ASC')
            ->getQuery();

        return $this->paginate($query, $page, $limit);
    }

    private function paginate($query, $page = 1, $limit = 10)
    {
        $paginator = new \Doctrine\ORM\Tools\Pagination\Paginator($query);

        $paginator->getQuery()
            ->setFirstResult($limit * ($page - 1))
            ->setMaxResults($limit);

        return $paginator;
    }

    public function searchByNameAndFamily($name, $family)
    {
        $queryBuilder = $this->createQueryBuilder('f');

        if (!empty($name)) {
            $queryBuilder->andWhere('f.name LIKE :name')
                ->setParameter('name', '%' . $name . '%');
        }

        if (!empty($family)) {
            $queryBuilder->andWhere('f.family LIKE :family')
                ->setParameter('family', '%' . $family . '%');
        }

        return $queryBuilder->getQuery()->getResult();
    }

    public function getUniqueFamilyNames(): array
    {
        $qb = $this->createQueryBuilder('f')
            ->select('DISTINCT f.family')
            ->orderBy('f.family', 'ASC');

        $results = $qb->getQuery()->getResult();

        $familyNames = [];
        foreach ($results as $result) {
            $familyNames[] = $result['family'];
        }

        return $familyNames;
    }
}
