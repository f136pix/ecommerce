<?php

namespace App\Application\GraphQL;

use App\Application\Interfaces\GraphQLResolver;
use App\Domain\Product as ProductEntity;
use GraphQL\Doctrine\Types;
use Doctrine\ORM\EntityManagerInterface;
use GraphQL\Type\Definition\Type;

class Products implements GraphQLResolver
{
    private Types $types;
    private EntityManagerInterface $entityManager;

    public function __construct(Types $types, EntityManagerInterface $entityManager)
    {
        $this->types = $types;
        $this->entityManager = $entityManager;
    }

    public function getField(): array
    {
        return [
            'type' => Type::listOf($this->types->getOutput(ProductEntity::class)),
            'args' => [
                [
                    'name' => 'filter',
                    'type' => $this->types->getFilter(ProductEntity::class),
                ],
                [
                    'name' => 'sorting',
                    'type' => $this->types->getSorting(ProductEntity::class),
                ],
            ],
            'resolve' => [$this, 'resolve'],
        ];
    }

    public function resolve($root, $args)
    {
        $queryBuilder = $this->types->createFilteredQueryBuilder(
            ProductEntity::class,
            $args['filter'] ?? [],
            $args['sorting'] ?? []
        );

        return $queryBuilder->getQuery()->getResult();
    }
}
