<?php

namespace App\Presentation\Contracts;

use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class OrdersContract
{
    // Create CreateOrderResolver
    public static function createOrderInput(): InputObjectType
    {
        return new InputObjectType([
            'name' => 'CreateOrderInput',
            'fields' => [
                'orderItems' => Type::listOf(Type::nonNull(self::createOrderItemInput())),
            ],
        ]);
    }

    public static function createOrderItemInput(): InputObjectType
    {
        return new InputObjectType([
            'name' => 'OrderItemInput',
            'fields' => [
                'productAttributeValueIds' => Type::listOf(Type::nonNull(Type::id())),
                'amount' => Type::nonNull(Type::int()),
            ],
        ]);
    }

    // CreateOrderType
    public static function orderType(): ObjectType
    {
        return new ObjectType([
            'name' => 'CreateOrderType',
            'fields' => [
                'id' => Type::nonNull(Type::id()),
                'status' => Type::nonNull(Type::string()),
            ],
        ]);
    }
}
