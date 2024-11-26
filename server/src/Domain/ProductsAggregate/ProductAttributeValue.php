<?php

namespace App\Domain\ProductsAggregate;

use App\Domain\BaseEntity;
use App\Domain\ProductsAggregate\AttributeValue;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="product_attribute_values")
 */
#[ORM\Entity, ORM\Table(name: 'product_attribute_values')]
class ProductAttributeValue extends BaseEntity
{
    public function __construct()
    {
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getAttributeSet(): AttributeSet
    {
        return $this->attributeSet;
    }

    public function getAttributeValue(): AttributeValue
    {
        return $this->attributeValue;
    }

    public function setProduct(Product $product): void
    {
        $this->product = $product;
    }

    public function setAttributeSet(AttributeSet $attributeSet): void
    {
        $this->attributeSet = $attributeSet;
    }

    public function setAttributeValue(AttributeValue $attributeValue): void
    {
        $this->attributeValue = $attributeValue;
    }

    /**
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="attributeValues")
     */
    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'attributeValues')]
    private Product $product;

    /**
     * @ORM\ManyToOne(targetEntity=AttributeSet::class)
     */
    #[ORM\ManyToOne(targetEntity: AttributeSet::class)]
    private AttributeSet $attributeSet;

    /**
     * @ORM\ManyToOne(targetEntity=AttributeValue::class)
     */
    #[ORM\ManyToOne(targetEntity: AttributeValue::class)]
    private AttributeValue $attributeValue;
}
