<?php

namespace App\Repository;

use App\Entity\Blog;
use App\Filter\BlogFilter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Blog>
 */
class BlogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Blog::class);
    }

    /**
     * @return array<Blog>
     */
    public function getBlogs(): array
    {
        return $this
            ->createQueryBuilder('b')
//            ->setMaxResults(6)
            ->getQuery()
            ->getResult();
    }

    public function findByBlogFilter(BlogFilter $blogFilter)
    {
        $blogs = $this->createQueryBuilder('b');

        if ($blogFilter->getTitle()){
            $blogs
                ->andWhere('b.title LIKE :title')
                ->setParameter('title', '%' . $blogFilter->getTitle() . '%');
        }

        if ($blogFilter->getDescription()){
            $blogs
                ->andWhere('b.description LIKE :description')
                ->setParameter('description', '%' . $blogFilter->getDescription() . '%');
        }

        return $blogs->getQuery()->getResult();
    }

}
