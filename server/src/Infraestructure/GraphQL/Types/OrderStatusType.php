<?php

namespace App\Infraestructure\GraphQL\Types;

use App\Domain\OrdersAggregate\OrderStatus;
use GraphQL\Language\AST\Node;
use GraphQL\Type\Definition\EnumType;
use GraphQL\Type\Definition\ScalarType;

//class OrderStatusType extends EnumType
//{
//    public function __construct()
//    {
//        $config = [
//            'name' => 'OrderStatus',
//            'values' => [
//                'PENDING' => [
//                    'value' => OrderStatus::PENDING,
//                    'description' => 'CreateOrderResolver is pending'
//                ],
//                'PROCESSING' => [
//                    'value' => OrderStatus::PROCESSING,
//                    'description' => 'CreateOrderResolver is being processed'
//                ],
//                'COMPLETED' => [
//                    'value' => OrderStatus::COMPLETED,
//                    'description' => 'CreateOrderResolver has been completed'
//                ],
//                'CANCELLED' => [
//                    'value' => OrderStatus::CANCELLED,
//                    'description' => 'CreateOrderResolver has been cancelled'
//                ]
//            ]
//        ];
//
//        parent::__construct($config);
//    }
//
//    public function serialize($value)
//    {
//        if ($value instanceof OrderStatus) {
//            return $value->value;
//        }
//        return null;
//    }
//
//    public function parseValue($value)
//    {
//        return OrderStatus::tryFrom($value);
//    }
//
//    public function parseLiteral(Node $valueNode, ?array $variables = null)
//    {
//        return OrderStatus::tryFrom($valueNode->value);
//    }
//}


class OrderStatusType extends ScalarType
{
    public string $name = 'OrderStatus';

    public function serialize($value)
    {
        if ($value instanceof OrderStatus) {
            return $value->value;
        }
        return null;
    }

    public function parseValue($value)
    {
        return OrderStatus::tryFrom($value);
    }

    public function parseLiteral(Node $valueNode, ?array $variables = null)
    {
        return OrderStatus::tryFrom($valueNode->value);
    }
}
