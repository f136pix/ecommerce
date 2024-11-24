<?php

namespace App\Domain\ProductsAggregate;

use App\Domain\BaseEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="attribute_values")
 */
#[ORM\Entity, ORM\Table(name: 'attribute_values')]
class AttributeValue extends BaseEntity
{
    /**
     * @param string $value
     * @param string $displayValue
     */
    public function __construct(string $value, string $displayValue)
    {
        $this->value = $value;
        $this->displayValue = $displayValue;
    }

    public function getAttributeSet(): AttributeSet
    {
        return $this->attributeSet;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getDisplayValue(): string
    {
        return $this->displayValue;
    }

    public function setAttributeSet(AttributeSet $attributeSet): void
    {
        $this->attributeSet = $attributeSet;
    }

    /**
     * @ORM\ManyToOne(targetEntity=AttributeSet::class, inversedBy="items")
     */
    #[ORM\ManyToOne(targetEntity: AttributeSet::class, inversedBy: 'items')]
    private AttributeSet $attributeSet;

    /**
     * @ORM\Column(length=255)
     */
    #[ORM\Column(length: 255)]
    private string $displayValue;

    /**
     * @ORM\Column(length=255)
     */
    #[ORM\Column(length: 255)]
    private string $value;
}