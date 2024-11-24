<?php

namespace App\Application\Resolvers\Queries;

use App\Application\Interfaces\GraphQLResolver;
use App\Domain\ProductsAggregate\Product as ProductEntity;
use GraphQL\Doctrine\Types;
use GraphQL\Type\Definition\Type;

class Products implements GraphQLResolver
{
    private Types $types;

    public function __construct(Types $types)
    {
        $this->types = $types;
    }

    public function getField(): array
    {
        error_log(Type::listOf($this->types->getOutput(ProductEntity::class)));


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

        error_log($queryBuilder->getQuery()->getSQL() .
            "\n" . json_encode($queryBuilder->getQuery()->getParameters()) . "\n");

        return $queryBuilder->getQuery()->getResult();
    }
}
