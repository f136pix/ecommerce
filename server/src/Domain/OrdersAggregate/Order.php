<?php

namespace App\Domain\OrdersAggregate;

use App\Domain\TimestampedEntity;
use App\Infraestructure\GraphQL\Types\OrderStatusType;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use GraphQL\Doctrine\Attribute as API;

/**
 * @ORM\Entity
 * @ORM\Table(name="orders")
 */
#[ORM\Entity, ORM\Table(name: 'orders')]
class Order extends TimestampedEntity
{
    public function __construct(
        OrderStatus $status = OrderStatus::PROCESSING
    ) {
        $this->status = $status;
    }

    /**
     * @ORM\Column(length=255)
     */
    #[ORM\Column(length: 255)]
    public OrderStatus $status = OrderStatus::PROCESSING;

    /**
     * @ORM\OneToMany(targetEntity=OrderItem::class, mappedBy="order")
     */
    #[ORM\OneToMany(mappedBy: 'order', targetEntity: OrderItem::class)]
    public Collection $orderItems;

    public function getStatus(): OrderStatus
    {
        return $this->status;
    }

    public function getOrderItems(): Collection
    {
        return $this->orderItems;
    }

    public function addOrderItem(OrderItem $orderItem): void
    {
        $this->orderItems->add($orderItem);
    }
}
