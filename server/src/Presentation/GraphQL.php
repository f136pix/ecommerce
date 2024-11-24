<?php

namespace App\Presentation;

use App\Application\Exceptions\PublicException;
use App\Application\GraphQL\ResolverFactory;
use Doctrine\ORM\EntityManager;
use GraphQL\Doctrine\DefaultFieldResolver;
use GraphQL\Doctrine\Types;
use GraphQL\GraphQL as GraphQLBase;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Schema;
use GraphQL\Type\SchemaConfig;
use RuntimeException;
use Throwable;

class GraphQL
{
//    private Types $types;
    private EntityManager $entityManager;
    private Types $types;
    private ResolverFactory $resolverFactory;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->types = new Types($this->entityManager);
        $this->resolverFactory = new ResolverFactory($this->types, $this->entityManager);
    }

    public function handle()
    {
        try {
            GraphQLBase::setDefaultFieldResolver(new DefaultFieldResolver());

            $queryType = new ObjectType([
                'name' => 'Query',
                'fields' => [
                    'echo' => [
                        'type' => Type::string(),
                        'args' => [
                            'message' => ['type' => Type::string()],
                        ],
                        'resolve' =>
                            static fn($rootValue, array $args): string => $rootValue['prefix'] . $args['message'],
                    ],
                    'products' => fn() => $this->resolverFactory
                        ->getResolver('products')
                        ->getField(),
                    'product' => fn() => $this->resolverFactory
                        ->getResolver('product')
                        ->getField()
                ],
            ]);

            $mutationType = new ObjectType([
                'name' => 'Mutation',
                'fields' => [
                    'sum' => [
                        'type' => Type::int(),
                        'args' => [
                            'x' => ['type' => Type::int()],
                            'y' => ['type' => Type::int()],
                        ],
                        'resolve' => static fn($calc, array $args): int => $args['x'] + $args['y'],
                    ],
                ],
            ]);

            $schema = new Schema(
                (new SchemaConfig())
                    ->setQuery($queryType)
                    ->setMutation($mutationType)
            );

            $rawInput = file_get_contents('php://input');
            if ($rawInput === false) {
                throw new RuntimeException('Failed to get php://input');
            }

            $input = json_decode($rawInput, true);
            $query = $input['query'];
            $variableValues = $input['variables'] ?? null;
            $rootValue = ['prefix' => 'You said: '];
            $result = GraphQLBase::executeQuery($schema, $query, $rootValue, null, $variableValues);
            $output = $result->toArray();
            // echo $queryType['fields']['products']['type'];
        } catch (Throwable $e) {
            if ($e instanceof PublicException) {
                $output = [
                    'error' => [
                        'message' => $e->getMessage(),
                    ],
                ];
            } else {
                http_response_code(500);
                $output = [
                    'error' => [
                        'message' => 'An error occurred, please try again later',
                    ],
                ];
            }
            error_log($e->getMessage() . PHP_EOL . $e->getTraceAsString());
        }

        header('Content-Type: application/json; charset=UTF-8');
        return json_encode($output);
    }
}
