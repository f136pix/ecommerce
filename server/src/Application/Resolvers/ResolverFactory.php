<?php

namespace App\Application\Resolvers;

use App\Application\Interfaces\GraphQLResolver;
use App\Application\Resolvers\Mutations\Order as OrderMutator;
use App\Application\Resolvers\Queries\Product as ProductResolver;
use App\Application\Resolvers\Queries\Products as ProductsResolver;
use GraphQL\Doctrine\Types;

class ResolverFactory
{
    private array $resolvers = [];
    private Types $types;

    public function __construct(Types $types)
    {
        $this->types = $types;
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
            'product' => new ProductResolver($this->types),
            'products' => new ProductsResolver($this->types),
            'order' => new OrderMutator($this->types),
            default => throw new \InvalidArgumentException("Unknown resolver: $name")
        };
    }
}
