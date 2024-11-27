<?php

namespace App\Application\Resolvers\Mutations;

use App\Application\Interfaces\GraphQLResolver;
use App\Domain\OrdersAggregate\Order as OrderEntity;
use App\Domain\OrdersAggregate\OrderItem;
use App\Domain\ProductsAggregate\ProductAttributeValue;
use Doctrine\ORM\EntityManager;
use GraphQL\Doctrine\Types;
use GraphQL\Type\Definition\InputObjectType;
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
        $orderItemInputType = new InputObjectType([
            'name' => 'OrderItemInput',
            'fields' => [
                'product_attribute_value_id' => Type::nonNull(Type::id()),
                'quantity' => Type::nonNull(Type::int()),
            ],
        ]);

        $orderInputType = new InputObjectType([
            'name' => 'OrderInput',
            'fields' => [
                'OrderItems' => Type::nonNull(Type::listOf($orderItemInputType)),
            ],
        ]);

        return [
            'type' => Type::nonNull($this->types->getOutput(OrderEntity::class)),
            'args' => [
                'input' => Type::nonNull($orderInputType),
            ],
            'resolve' => [$this, 'resolve'],
        ];
    }

    public function resolve($root, array $args, $context, $info)
    {
        $requestItems = $args['input']['OrderItems'];

        $productAttributeValueIds = array_column($requestItems, 'product_attribute_value_id');

        $productAttributeValues = $this->entityManager
            ->getRepository(ProductAttributeValue::class)
            ->findBy(['id' => $productAttributeValueIds]);

        $productAttributeValueMap = array_combine(
            array_map(fn($pav) => $pav->getId(), $productAttributeValues),
            $productAttributeValues
        );

        $this->entityManager->beginTransaction();
        try {
            $order = new OrderEntity();
            $this->entityManager->persist($order);

            $orderItems = [];
            foreach ($requestItems as $item) {
                $orderItem = new OrderItem($order);

                $productAttributeValue = $productAttributeValueMap[$item['product_attribute_value_id']] ?? null;
                if ($productAttributeValue) {
                    $orderItem->addProductAttributeValue($productAttributeValue);
                }

                $orderItem->setOrder($order);
                $this->entityManager->persist($orderItem);

                $orderItems[] = $orderItem;
            }

            $this->entityManager->flush();
            $this->entityManager->commit();

//            $requestedFields = $info->getFieldSelection(2);
//
//            if (isset($requestedFields['orderItems'])) {
//                $orderItems = $this->entityManager
//                    ->getRepository(OrderItem::class)
//                    ->findBy(['order' => $order]);
//                $order = $this->entityManager->getRepository(OrderEntity::class)->find();
//            }

            return $order;
        } catch (\Throwable $e) {
            error_log($e->getTraceAsString());
            $this->entityManager->rollback();
            throw $e;
        }
    }
}
