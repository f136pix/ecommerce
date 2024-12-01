<?php

namespace App\Domain\ProductsAggregate;

use Doctrine\ORM\Mapping as ORM;


use App\Domain\BaseEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="attribute_values")
 */
class AttributeValue extends BaseEntity
{
    /**
     * @ORM\ManyToOne(targetEntity=AttributeSet::class, inversedBy="items")
     */
    private AttributeSet $attributeSet;
    /**
     * @ORM\Column(length=255)
     */
    private string $displayValue;
    /**
     * @ORM\Column(length=255)
     */
    private string $value;

    /**
     * @param string $value
     * @param string $displayValue
     */
    public function __construct()
    {
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
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     * @return void
     */
    public function setValue(string $value): void
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getDisplayValue(): string
    {
        return $this->displayValue;
    }

    /**
     * @param string $displayValue
     * @return void
     */
    public function setDisplayValue(string $displayValue): void
    {
        $this->displayValue = $displayValue;
    }
}
