<?php

namespace App\Application\Interfaces;

interface GraphQLResolver
{
    /**
     * Resolve the GraphQL query
     *
     * @param mixed $root
     * @param array $args
     * @return mixed
     */
    public function resolve($root, array $args, $context, $info);
}
