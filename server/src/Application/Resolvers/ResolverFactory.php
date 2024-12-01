<?php

namespace App\Application\Resolvers;

use App\Application\Interfaces\GraphQLResolver;
use App\Application\Resolvers\Mutations\CreateOrderResolver;
use App\Application\Resolvers\Mutations\CreateOrderResolver as OrderMutator;
use App\Application\Resolvers\Queries\GetProductAttributesResolver;
use App\Application\Resolvers\Queries\GetProductResolver;
use App\Application\Resolvers\Queries\GetProductsResolver;
use Doctrine\ORM\EntityManager;
use InvalidArgumentException;

class ResolverFactory
{
    private array $resolvers = [];

    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getResolver(string $name): GraphQLResolver
    {
        if (!isset($this->resolvers[$name])) {
            $this->resolvers[$name] = $this->createResolver($name);
        }

        return $this->resolvers[$name];
    }

    private function createResolver(string $name): GraphQLResolver
    {
        return match ($name) {
            'product' => new GetProductResolver($this->entityManager),
            'products' => new GetProductsResolver($this->entityManager),
            'productAttributes' => new GetProductAttributesResolver($this->entityManager),
            'createOrder' => new CreateOrderResolver($this->entityManager),
            default => throw new InvalidArgumentException("Unknown resolver: $name")
        };
    }
}
