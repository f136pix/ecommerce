<?php

namespace App\Infraestructure\GraphQL;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Schema;
use GraphQL\Type\SchemaConfig;

// Helper function for builduing schemas
class GraphQLSchemaBuilder
{
    private array $queryFields = [];
    private array $mutationFields = [];

    public function addQueryField(string $name, array $fieldConfig): self
    {
        $this->queryFields[$name] = $fieldConfig;
        return $this;
    }

    public function addMutationField(string $name, array $fieldConfig): self
    {
        $this->mutationFields[$name] = $fieldConfig;
        return $this;
    }

    public function build(): Schema
    {
        $queryType = new ObjectType([
            'name' => 'Query',
            'fields' => $this->queryFields
        ]);

        $mutationType = new ObjectType([
            'name' => 'Mutation',
            'fields' => $this->mutationFields
        ]);

        return new Schema(
            (new SchemaConfig())
                ->setQuery($queryType)
                ->setMutation($mutationType)
        );
    }
}