<?php

namespace App\Presentation;

use App\Application\Exceptions\PublicException;
use App\Application\Resolvers\ResolverFactory;
use App\Domain\OrdersAggregate\OrderItem;
use App\Domain\OrdersAggregate\OrderStatus;
use App\Infraestructure\DependencyInjection\SimpleContainer;
use App\Infraestructure\GraphQL\Types\DateTimeType;
use App\Infraestructure\GraphQL\Types\OrderStatusType;
use DateTime;
use Doctrine\ORM\EntityManager;
use GraphQL\Doctrine\DefaultFieldResolver;
use GraphQL\Doctrine\Types;
use GraphQL\GraphQL as GraphQLBase;
use GraphQL\Type\Definition\ObjectType;
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

        $customTypes = new SimpleContainer([
            'invokables' => [
                DateTime::class => DateTimeType::class,
                OrderStatus::class => OrderStatusType::class,
            ],
        ]);

        $this->types = new Types($this->entityManager, $customTypes);
        $this->resolverFactory = new ResolverFactory($this->types);
    }

    public function handle()
    {

        try {
            GraphQLBase::setDefaultFieldResolver(new DefaultFieldResolver());

            $queryType = new ObjectType([
                'name' => 'Query',
                'fields' => [
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
                    'createOrder' => fn() => $this->resolverFactory
                        ->getResolver('order')
                        ->getField(),
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
