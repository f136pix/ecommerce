<?php

namespace App\Presentation\Contracts;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class AttributesContracts
{
    public static function attributeType(): ObjectType
    {
        return new ObjectType([
            'name' => 'Attribute',
            'fields' => [
                'name' => Type::nonNull(Type::string()),
                'values' => Type::listOf(new ObjectType([
                    'name' => 'AttributeValue',
                    'fields' => [
                        'value' => Type::nonNull(Type::string()),
                        'displayValue' => Type::nonNull(Type::string()),
                        'id' => Type::nonNull(Type::int()),
                    ],
                ])),
            ],
        ]);
    }
}
