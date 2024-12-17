<?php

namespace App\Presentation\Contracts;

use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class ProductsContracts
{
    public static function productType(): ObjectType
    {
        return new ObjectType([
            'name' => 'Product',
            'fields' => [
                'id' => Type::nonNull(Type::id()),
                'name' => Type::string(),
                'inStock' => Type::boolean(),
                'price' => Type::float(),
                'description' => Type::string(),
                'images' => [
                    'type' => Type::listOf(ProductsContracts::productImageType()),
                ],
                'category' => [
                    'type' => Type::nonNull(CategoriesContract::categoryType()),
                ],
                'attributes' => [
                    'type' => Type::listOf(AttributesContracts::attributeType()),
                ],
            ],
        ]);
    }

    public static function productImageType(): ObjectType
    {
        return new ObjectType([
            'name' => 'Image',
            'fields' => [
                'id' => Type::nonNull(Type::id()),
                'url' => Type::string(),
                'position' => Type::int(),
            ],
        ]);
    }

    public static function productFilterInput(): InputObjectType
    {
        return new InputObjectType([
            'name' => 'ProductFilterInput',
            'fields' => [
                'name' => Type::string(),
                'category' => Type::string(),
                'priceMin' => Type::float(),
                'priceMax' => Type::float(),
            ],
        ]);
    }
}
