<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Class AbstractRepository
 * @package App\Repository
 * @author Guillermo Quinteros A. <gu.quinteros@gmail.com>
 */
abstract class AbstractRepository extends ServiceEntityRepository
{
    /**
     * AbstractRepository constructor.
     * @param RegistryInterface $registry
     * @param string $class
     */
    public function __construct(RegistryInterface $registry, string $class)
    {
        parent::__construct($registry, $class);
    }

    /**
     * @param string $q
     * @param array $fields
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function search(?string $q, ?array $fields)
    {
        $queryBuilder = $this->createQueryBuilder('r');

        if (empty($fields)) {
            throw new BadRequestHttpException('Missing fields');
        }

        if ($q) {
            foreach ($fields as $field) {
                $queryBuilder->orWhere('r.'.$field.' like :q');
            }
            $queryBuilder->setParameter('q', '%'.$q.'%');
        }

        $queryBuilder->addOrderBy('r.id', 'ASC');

        return $queryBuilder;
    }
}
