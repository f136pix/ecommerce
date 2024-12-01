<?php

namespace App\Infraestructure\GraphQL\Types;

use GraphQL\Language\AST\Node;
use GraphQL\Type\Definition\ScalarType;

class DateTimeType extends ScalarType
{
    public string $name = 'DateTime';

    public function serialize($value)
    {
    // Convert to ISO 8601 format
        return $value instanceof \DateTimeInterface
        ? $value->format('c')
        : null;
    }

    public function parseValue($value)
    {
    // Parse from ISO 8601 format
        return $value ? new \DateTime($value) : null;
    }

    public function parseLiteral(Node $valueNode, ?array $variables = null)
    {
    // Handle literal parsing from GraphQL query
        if (!method_exists($valueNode, 'value')) {
            throw new \Exception('Invalid datetime');
        }

        return new \DateTime($valueNode->value);
    }
}
