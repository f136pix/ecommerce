<?php

namespace App\Application\Resolvers\Queries;

use App\Application\Exceptions\PublicException;
use App\Application\Interfaces\GraphQLResolver;
use App\Domain\ProductsAggregate\Product as ProductEntity;
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
            $productId = $args['productId'] ?? null;

            if ($productId === null) {
                throw new PublicException("Product ID is required");
            }

            $qb = $this->entityManager->createQueryBuilder();
            $qb->select('pav')
                ->from(ProductAttributeValue::class, 'pav')
                ->join('pav.attributeSet', 'as')
                ->join('pav.attributeValue', 'av')
                ->join('pav.product', 'p')
                ->where('p.id = :productId')
                ->setParameter(':productId', $productId);

            $productAttributeValues = $qb->getQuery()->getResult();

            $attributes = [];
            foreach ($productAttributeValues as $productAttributeValue) {
                $attributeName = $productAttributeValue->getAttributeSet()->getName();
                $attributeValue = $productAttributeValue->getAttributeValue();

                if (!isset($attributes[$attributeName])) {
                    $attributes[$attributeName] = [];
                }

                $attributes[$attributeName][] = [
                    'id' => $productAttributeValue->getId(),
                    'value' => $attributeValue->getValue(),
                    'displayValue' => $attributeValue->getDisplayValue(),
                ];
            }

            $formattedAttributes = [];
            foreach ($attributes as $name => $values) {
                $formattedAttributes[] = [
                    'name' => $name,
                    'values' => $values,
                ];
            }

            return $formattedAttributes;
        } catch (Throwable $e) {
            error_log($e->getTraceAsString());
            throw new PublicException("There was an error fetching product attributes");
        }
    }
}
