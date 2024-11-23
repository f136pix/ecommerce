<?php

namespace App\Application\GraphQL;

use App\Application\Interfaces\GraphQLResolver;
use App\Domain\Product as ProductEntity;
use GraphQL\Doctrine\Types;
use Doctrine\ORM\EntityManagerInterface;
use GraphQL\Type\Definition\Type;

class Product implements GraphQLResolver
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
            'type' => Type::assertType($this->types->getOutput(ProductEntity::class)),
            'args' => [
                'id' => $this->types->getId(ProductEntity::class),
            ],
            'resolve' => [$this, 'resolve'],
        ];
    }

    public function resolve($root, array $args)
    {
        return $args['id']->getEntity();
    }
}
