<?php

namespace App\Application\GraphQL;

use App\Application\GraphQL\Product as ProductResolver;
use App\Application\GraphQL\Products as ProductsResolver;
use App\Application\Interfaces\GraphQLResolver;
use Doctrine\ORM\EntityManager;
use GraphQL\Doctrine\Types;

class ResolverFactory
{
    private array $resolvers = [];
    private Types $types;
    private EntityManager $entityManager;

    public function __construct(Types $types, EntityManager $entityManager)
    {
        $this->types = $types;
        $this->entityManager = $entityManager;
    }

    public function getResolver(string $name): GraphQLResolver
    {
        if (!isset($this->resolvers[$name])) {
            $this->resolvers[$name] = $this->createResolver($name);
        }

        return $this->resolvers[$name];
    }

    private function createResolver(string $name): Product|Products
    {
        return match ($name) {
            'product' => new ProductResolver($this->types, $this->entityManager),
            'products' => new ProductsResolver($this->types, $this->entityManager),
            default => throw new \InvalidArgumentException("Unknown resolver: $name")
        };
    }
}
