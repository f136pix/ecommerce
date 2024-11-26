<?php

namespace App\Application\Resolvers\Mutations;

use App\Application\Interfaces\GraphQLResolver;
use App\Domain\OrdersAggregate\Order as OrderEntity;
use Doctrine\ORM\EntityManager;
use GraphQL\Doctrine\Types;
use GraphQL\Type\Definition\Type;

class Order implements GraphQLResolver
{
    private Types $types;
    private EntityManager $entityManager;

    public function __construct(Types $types)
    {
        $this->types = $types;
        $this->entityManager = require __DIR__ . '/../../../Infraestructure/Persistence/doctrine.php';
    }

    public function getField(): array
    {
        return [
            'type' => Type::nonNull($this->types->getOutput(OrderEntity::class)),
            'args' => [
                'input' => Type::nonNull($this->types->getInput(OrderEntity::class)),
            ],
            'resolve' => [$this, 'resolve'],
        ];
    }

    public function resolve($root, array $args)
    {
        $order = $args['input']->getEntity();
        $this->entityManager->persist($order);
        $this->entityManager->flush();
        return $order;
    }
}
