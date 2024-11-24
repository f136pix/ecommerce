<?php

namespace App\Application\Resolvers\Queries;

use App\Application\Interfaces\GraphQLResolver;
use App\Domain\ProductsAggregate\Product as ProductEntity;
use GraphQL\Doctrine\Types;
use GraphQL\Type\Definition\Type;

class Product implements GraphQLResolver
{
    private Types $types;

    public function __construct(Types $types)
    {
        $this->types = $types;
    }

    public function getField(): array
    {
        return [
            'type' => Type::nonNull($this->types->getOutput(ProductEntity::class)),
            'args' => [
                'id' => $this->types->getId(ProductEntity::class),
            ],
            'resolve' => [$this, 'resolve'],
        ];
    }

    public function resolve($root, array $args)
    {
//        return $this->entityManager->getRepository(ProductEntity::class)->find($args['id']);
        return $args['id']->getEntity();
    }
}
