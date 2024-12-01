<?php

namespace App\Application\Resolvers\Queries;

use App\Application\Exceptions\PublicException;
use App\Application\Interfaces\GraphQLResolver;
use App\Domain\ProductsAggregate\Product as ProductEntity;
use App\Domain\ProductsAggregate\ProductImage as ProductImage;
use Doctrine\ORM\EntityManager;
use Throwable;

class GetProductsResolver implements GraphQLResolver
{
    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function resolve($root, $args, $context, $info = null)
    {
        try {
            $filters = $args['filter'] ?? [];

            $qb = $this->entityManager->createQueryBuilder();
            $qb->select('p')
                ->from(ProductEntity::class, 'p')
                ->leftJoin('p.category', 'c');

            if (isset($filters['name'])) {
                $qb->andWhere('p.name LIKE :name')
                    ->setParameter('name', '%' . $filters['name'] . '%');
            }

            if (isset($filters['category'])) {
                $qb->andWhere('c.name = :category')
                    ->setParameter('category', $filters['category']);
            }

            $res = $qb->getQuery()->getResult();

            return array_map(function ($product) {
                return [
                    'id' => $product->getId(),
                    'name' => $product->getName(),
                    'price' => $product->getPrice(),
                    'inStock' => $product->isInStock(),
                    'images' => array_map(function (ProductImage $image) {
                        return [
                            'id' => $image->getId(),
                            'url' => $image->getUrl(),
                            'position' => $image->getPosition(),
                        ];
                    }, $product->getImages()->toArray()),
                    'category' => [
                        'id' => $product->getCategory()->getId(),
                        'name' => $product->getCategory()->getName(),
                    ],
                ];
            }, $res);
        } catch (Throwable $e) {
            throw new PublicException("There was a error fetching the products");
        }
    }
}
