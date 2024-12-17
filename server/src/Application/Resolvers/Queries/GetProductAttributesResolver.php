<?php

namespace App\Application\Resolvers\Queries;

use App\Application\Exceptions\PublicException;
use App\Application\Interfaces\GraphQLResolver;
use App\Domain\ProductsAggregate\ProductAttributeValue;
use Doctrine\ORM\EntityManager;
use Throwable;

class GetProductAttributesResolver implements GraphQLResolver
{
    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function resolve($root, $args, $context, $info = null)
    {
        try {
            $productId = $args['productId'] ?? throw new PublicException("Product ID is required");

            $qb = $this->entityManager->createQueryBuilder();
            $qb->select('pav', 'av', 'attributeSet')
                ->from(ProductAttributeValue::class, 'pav')
                ->join('pav.attributeSet', 'attributeSet')
                ->join('pav.attributeValue', 'av')
                ->where('pav.product = :product')
                ->setParameter('product', $productId);

            $productAttributeValues = $qb->getQuery()
                ->useQueryCache(true)  // Enable query result caching
                ->setHint('doctrine.query_hint.cacheable', true)
                ->getResult();

            $formattedAttributes = array_reduce($productAttributeValues, function ($carry, $productAttributeValue) {
                $attributeName = $productAttributeValue->getAttributeSet()->getName();
                $attributeValue = $productAttributeValue->getAttributeValue();

                $carry[$attributeName][] = [
                    'id' => $productAttributeValue->getId(),
                    'value' => $attributeValue->getValue(),
                    'displayValue' => $attributeValue->getDisplayValue(),
                ];

                return $carry;
            }, []);

            return array_map(fn($name, $values) => [
                'name' => $name,
                'values' => $values
            ], array_keys($formattedAttributes), $formattedAttributes);
        } catch (Throwable $e) {
            error_log('Product attribute fetch error', [
                'productId' => $productId ?? 'unknown',
                'error' => $e->getMessage()
            ]);
            throw new PublicException("There was an error fetching product attributes");
        }
    }
}
