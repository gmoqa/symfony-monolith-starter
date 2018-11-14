<?php

namespace App\Repository;

use App\Entity\Post;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class PostRepository
 * @package App\Repository
 */
class PostRepository extends AbstractRepository
{
    /**
     * PostRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function test()
    {
        $this->createQueryBuilder()
        ->getQuery()
        ->getRe;
    }
}
