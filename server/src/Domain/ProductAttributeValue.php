<?php

namespace App\Domain;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'product_attribute_values')]
class ProductAttributeValue extends BaseEntity
{
    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'attributeValues')]
    private Product $product;

    #[ORM\ManyToOne(targetEntity: AttributeSet::class)]
    private AttributeSet $attributeSet;

    #[ORM\ManyToOne(targetEntity: AttributeValue::class)]
    private AttributeValue $attributeValue;
}
