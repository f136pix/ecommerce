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
#[ORM\Entity, ORM\Table(name: 'order_items')]
class OrderItem extends BaseEntity
{
    public function __construct(
        Order $order = null,
        Collection $productAttributeValues = null
    ) {
        $this->order = $order;
        $this->productAttributeValues = $productAttributeValues ?: new ArrayCollection();
    }

    public function getOrder(): Order
    {
        return $this->order;
    }

    public function getProductAttributeValues(): Collection
    {
        return $this->productAttributeValues;
    }


    public function setOrder(Order $order): void
    {
        $this->order = $order;
    }


    public function addProductAttributeValue(ProductAttributeValue $productAttributeValue): void
    {
        $this->productAttributeValues->add($productAttributeValue);
    }

    /**
     * @ORM\ManyToOne(targetEntity=Order::class, inversedBy="orderItems")
     * @ORM\JoinColumn(name="order_id", referencedColumnName="id", nullable=false)
     */
    #[ORM\ManyToOne(targetEntity: Order::class, inversedBy: 'orderItems')]
    #[ORM\JoinColumn(name: 'order_id', referencedColumnName: 'id', nullable: false)]
    private Order $order;

    /**
     * @ORM\ManyToMany(targetEntity=ProductAttributeValue::class)
     * @ORM\JoinTable(name="order_items_product_attribute_values",
     *      joinColumns={@ORM\JoinColumn(name="order_item_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="product_attribute_value_id", referencedColumnName="id")}
     * )
     */
    #[ORM\ManyToMany(targetEntity: ProductAttributeValue::class)]
    #[ORM\JoinTable(
        name: 'order_items_product_attribute_values',
        joinColumns: [new ORM\JoinColumn(name: 'order_item_id', referencedColumnName: 'id')],
        inverseJoinColumns: [new ORM\JoinColumn(name: 'product_attribute_value_id', referencedColumnName: 'id')]
    )]
    private Collection $productAttributeValues;
}
