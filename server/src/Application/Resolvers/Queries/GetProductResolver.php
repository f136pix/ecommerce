<?php

namespace App\Application\Resolvers\Queries;

use App\Application\Exceptions\PublicException;
use App\Application\Interfaces\GraphQLResolver;
use App\Domain\ProductsAggregate\Product as ProductEntity;
use Doctrine\ORM\EntityManager;
use Throwable;

class GetProductResolver implements GraphQLResolver
{
    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function resolve($root, $args, $context, $info = null)
    {
        try {
            $productId = $args['id'] ?? null;

            if ($productId === null) {
                throw new PublicException("Product ID is required");
            }

            $qb = $this->entityManager->createQueryBuilder();
            $qb->select('p')
                ->from(ProductEntity::class, 'p')
                ->leftJoin('p.category', 'c')
                ->where('p.id = :id')
                ->setParameter('id', $productId);

            $product = $qb->getQuery()->getOneOrNullResult();

            if ($product === null) {
                throw new PublicException("Product not found");
            }

            $ret = [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'inStock' => $product->isInStock(),
                'price' => $product->getPrice(),
                'category' => [
                    'id' => $product->getCategory()->getId(),
                    'name' => $product->getCategory()->getName(),
                ],
            ];

            // If client is requesting attributes, using attributes resolver to fetch it
            $fields = $info->getFieldSelection(1);
            if (isset($fields['attributes'])) {
                $attributesResolver = new GetProductAttributesResolver($this->entityManager);
                $ret['attributes'] = $attributesResolver->resolve($root, ['productId' => $ret['id']], $context, $info);
            }

            return $ret;
        } catch (Throwable $e) {
            throw new PublicException("There was an error fetching the product");
        }
    }
}
