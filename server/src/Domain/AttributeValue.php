<?php

namespace App\Domain;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'attribute_values')]
class AttributeValue extends BaseEntity
{
    #[ORM\ManyToOne(targetEntity: AttributeSet::class, inversedBy: 'items')]
    private AttributeSet $attributeSet;

    #[ORM\Column(length: 255)]
    private string $displayValue;

    #[ORM\Column(length: 255)]
    private string $value;
}
