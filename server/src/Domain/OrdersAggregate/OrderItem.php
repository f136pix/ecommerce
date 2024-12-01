<?php

namespace App\Domain\OrdersAggregate;

use App\Domain\BaseEntity;
use App\Domain\ProductsAggregate\ProductAttributeValue;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="order_items")
 */
class OrderItem extends BaseEntity
{
    /**
     * @ORM\ManyToOne(targetEntity=Order::class, inversedBy="orderItems")
     * @ORM\JoinColumn(name="order_id", referencedColumnName="id", nullable=false)
     */
    private Order $order;
    /**
     * @ORM\ManyToMany(targetEntity=ProductAttributeValue::class)
     * @ORM\JoinTable(name="order_item_product_attribute_values",
     *      joinColumns={@ORM\JoinColumn(name="order_item_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="product_attribute_value_id", referencedColumnName="id")}
     * )
     */
    private Collection $productAttributeValues;
    /**
     * @ORM\Column(type="integer")
     */
    private int $amount;

    /**
     *
     */
    public function __construct()
    {
        $this->productAttributeValues = new ArrayCollection(); // Recommended
    }

    /**
     * @param ProductAttributeValue $productAttributeValue
     * @return void
     */
    public function addProductAttributeValue(ProductAttributeValue $productAttributeValue): self
    {
        if (!$this->productAttributeValues->contains($productAttributeValue)) {
            $this->productAttributeValues->add($productAttributeValue);
        }
        return $this;
    }

    /**
     * @param ProductAttributeValue $productAttributeValue
     * @return void
     */
    public function removeProductAttributeValue(ProductAttributeValue $productAttributeValue): void
    {
        $this->productAttributeValues->removeElement($productAttributeValue);
    }

    /**
     * @return Order
     */
    public function getOrder(): Order
    {
        return $this->order;
    }

    /**
     * @param Order $order
     * @return void
     */
    public function setOrder(Order $order): void
    {
        $this->order = $order;
    }

    /**
     * @return Collection
     */
    public function getProductAttributeValues(): Collection
    {
        return $this->productAttributeValues;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     * @return void
     */
    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }
}
