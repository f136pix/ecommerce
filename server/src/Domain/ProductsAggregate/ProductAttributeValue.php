<?php

namespace App\Domain\ProductsAggregate;

use App\Domain\BaseEntity;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="product_attribute_values")
 */
class ProductAttributeValue extends BaseEntity
{
    /**
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="attributeValues")
     */
    private Product $product;
    /**
     * @ORM\ManyToOne(targetEntity=AttributeSet::class)
     */
    private AttributeSet $attributeSet;
    /**
     * @ORM\ManyToOne(targetEntity=AttributeValue::class)
     */
    private AttributeValue $attributeValue;

    /**
     *
     */
    public function __construct()
    {
    }

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * @param Product $product
     * @return void
     */
    public function setProduct(Product $product): void
    {
        $this->product = $product;
    }

    /**
     * @return AttributeSet
     */
    public function getAttributeSet(): AttributeSet
    {
        return $this->attributeSet;
    }

    /**
     * @param AttributeSet $attributeSet
     * @return void
     */
    public function setAttributeSet(AttributeSet $attributeSet): void
    {
        $this->attributeSet = $attributeSet;
    }

    /**
     * @return \App\Domain\ProductsAggregate\AttributeValue
     */
    public function getAttributeValue(): AttributeValue
    {
        return $this->attributeValue;
    }

    /**
     * @param \App\Domain\ProductsAggregate\AttributeValue $attributeValue
     * @return void
     */
    public function setAttributeValue(AttributeValue $attributeValue): void
    {
        $this->attributeValue = $attributeValue;
    }
}
