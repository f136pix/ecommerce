<?php

namespace App\Presentation;

use App\Application\Exceptions\PublicException;
use App\Application\Interfaces\GraphQLResolver;
use App\Application\Resolvers\ResolverFactory;
use App\Domain\OrdersAggregate\OrderStatus;
use App\Infraestructure\DependencyInjection\SimpleContainer;
use App\Infraestructure\GraphQL\GraphQLSchemaBuilder;
use App\Infraestructure\GraphQL\Types\DateTimeType;
use App\Infraestructure\GraphQL\Types\OrderStatusType;
use App\Presentation\Contracts\OrdersContract;
use App\Presentation\Contracts\ProductsContracts;
use DateTime;
use Doctrine\ORM\EntityManager;
use GraphQL\GraphQL as GraphQLBase;
use GraphQL\Type\Definition\Type;
use RuntimeException;
use Throwable;

require_once __DIR__ . '/ErrorHandler.php';


class GraphQL
{
    private EntityManager $entityManager;
    private GraphQLResolver $productsResolver;
    private ResolverFactory $resolverFactory;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->resolverFactory = new ResolverFactory($entityManager);

        $customTypes = new SimpleContainer([
            'invokables' => [
                DateTime::class => DateTimeType::class,
                OrderStatus::class => OrderStatusType::class,
            ],
        ]);
    }

    public function handle()
    {

        try {
            $schemaBuilder = new GraphQLSchemaBuilder();
            $schemaBuilder
                ->addQueryField('products', [
                    'type' => Type::listOf(Type::nonNull(ProductsContracts::productType())),
                    'args' => ['filter' => ProductsContracts::productFilterInput()],
                    'resolve' => [$this->resolverFactory->getResolver('products'), 'resolve']
                ])
                ->addQueryField('product', [
                    'type' => Type::nonNull(ProductsContracts::productType()),
                    'args' => ['id' => Type::nonNull(Type::id())],
                    'resolve' => [$this->resolverFactory->getResolver('product'), 'resolve']
                ])
                ->addMutationField('createOrder', [
                    'type' => Type::nonNull(OrdersContract::orderType()),
                    'args' => ['input' => Type::nonNull(OrdersContract::createOrderInput())],
                    'resolve' => [$this->resolverFactory->getResolver('createOrder'), 'resolve']
                ]);


            $schema = $schemaBuilder->build();

            $rawInput = file_get_contents('php://input');
            if ($rawInput === false) {
                throw new RuntimeException('Failed to get php://input');
            }

            $input = json_decode($rawInput, true);
            $query = $input['query'];
            $variableValues = $input['variables'] ?? null;
            $rootValue = ['prefix' => 'You said: '];
            $result = GraphQLBase::executeQuery($schema, $query, $rootValue, null, $variableValues)
                ->setErrorFormatter('customErrorFormatter')
                ->setErrorsHandler('customErrorHandler');
            $output = $result->toArray();
        } catch (Throwable $e) {
            http_response_code(500);
            $output = [
                'error' => [
                    'message' => 'An error occurred, please try again later',
                ],
            ];
        }
        error_log(json_encode($output));
        header('Content-Type: application/json; charset=UTF-8');
        return json_encode($output);
    }
}
