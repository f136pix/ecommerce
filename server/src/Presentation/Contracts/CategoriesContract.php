<?php

namespace App\Presentation\Contracts;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class CategoriesContract
{
    public static function categoryType(): ObjectType
    {
        return new ObjectType([
            'name' => 'Category',
            'fields' => [
                'id' => Type::nonNull(Type::int()),
                'name' => Type::string(),
            ],
        ]);
    }
}