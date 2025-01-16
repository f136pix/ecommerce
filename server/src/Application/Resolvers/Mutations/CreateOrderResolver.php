<?php

namespace App\Application\Resolvers\Mutations;

use App\Application\Exceptions\PublicException;
use App\Application\Interfaces\GraphQLResolver;
use App\Domain\OrdersAggregate\Order as OrderEntity;
use App\Domain\OrdersAggregate\OrderItem;
use App\Domain\ProductsAggregate\ProductAttributeValue;
use Doctrine\ORM\EntityManager;
use Exception;

class CreateOrderResolver implements GraphQLResolver
{
    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function resolve($root, array $args, $context, $info)
    {
        $this->entityManager->beginTransaction();

        try {
            $orderInput = $args['input'];
            $orderItemsInput = $orderInput['orderItems'];

            $order = new OrderEntity();
            $this->entityManager->persist($order);

            // extracting all the product attribute values ids
            $productAttributeValueIds = [];
            foreach ($orderItemsInput as $orderItemInput) {
                $productAttributeValueIds =
                    array_merge($productAttributeValueIds, $orderItemInput['productAttributeValueIds']);
            }

            // Avoiding n + 1 db queries
            $productAttributeValues = $this->entityManager
                ->getRepository(ProductAttributeValue::class)
                ->createQueryBuilder('pav')
                ->where('pav.id IN (:ids)')
                ->setParameter('ids', $productAttributeValueIds)
                ->getQuery()
                ->getResult();

            foreach ($productAttributeValues as $productAttributeValue) {
                $productAttributeValueMap[$productAttributeValue->getId()] = $productAttributeValue;
            }

            foreach ($orderItemsInput as $orderItemInput) {
                $orderItem = new OrderItem();
                $orderItem->setOrder($order);
                $orderItem->setAmount($orderItemInput['amount']);

                $productAttributeSets = [];
                foreach ($orderItemInput['productAttributeValueIds'] as $productAttributeValueId) {
                    if (isset($productAttributeValueMap[$productAttributeValueId])) {
                        $productAttributeValue = $productAttributeValueMap[$productAttributeValueId];
                        $attributeSetId = $productAttributeValue->getAttributeSet()->getId();

                        if (in_array($attributeSetId, $productAttributeSets)) {
                            throw new PublicException("You can not have more than one attribute for: "
                                . $productAttributeValue->getAttributeSet()->getName());
                        }

                        $productAttributeSets[] = $attributeSetId;
                        $orderItem->addProductAttributeValue($productAttributeValue);
                    }
                }

                $this->entityManager->persist($orderItem);
            }

            $this->entityManager->flush();
            $this->entityManager->commit();

            $ret = [
                'id' => $order->getId(),
                'status' => $order->getStatus()->value,
            ];

            return $ret;
        } catch (Exception $e) {
            $this->entityManager->rollback();
            throw $e;
        }
    }
}
