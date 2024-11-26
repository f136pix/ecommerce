<?php

namespace App\Domain\OrdersAggregate;

use App\Domain\TimestampedEntity;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="orders")
 */
#[ORM\Entity, ORM\Table(name: 'orders')]
class Order extends TimestampedEntity
{
    public function __construct(
        Collection $orderItems,
        OrderStatus $status = OrderStatus::PROCESSING
    ) {
        $this->status = $status;
        $this->orderItems = $orderItems;
    }

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

    /**
     * @ORM\Column(length=255)
     */
    #[ORM\Column(length: 255)]
    public OrderStatus $status;

    /**
     * @ORM\OneToMany(targetEntity=OrderItem::class, mappedBy="order")
     */
    #[ORM\OneToMany(mappedBy: 'order', targetEntity: OrderItem::class)]
    public Collection $orderItems;
}
