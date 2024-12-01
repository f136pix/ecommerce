<?php

namespace App\Domain\OrdersAggregate;

use App\Domain\TimestampedEntity;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="orders")
 */
class Order extends TimestampedEntity
{
    /**
     *
     */
    public function __construct()
    {
        $this->status = OrderStatus::PROCESSING;
    }

    /**
     * @ORM\Column(length=255)
     */
    public OrderStatus $status = OrderStatus::PROCESSING;

    /**
     * @ORM\OneToMany(targetEntity=OrderItem::class, mappedBy="order")
     */
    public Collection $orderItems;

    /**
     * @return OrderStatus
     */
    public function getStatus(): OrderStatus
    {
        return $this->status;
    }

    /**
     * @return Collection
     */
    public function getOrderItems(): Collection
    {
        return $this->orderItems;
    }

    /**
     * @param OrderItem $orderItem
     * @return void
     */
    public function addOrderItem(OrderItem $orderItem): void
    {
        $this->orderItems->add($orderItem);
    }
}
