<?php

namespace App\Domain\ProductsAggregate;

use App\Domain\BaseEntity;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="attribute_sets")
 */
class AttributeSet extends BaseEntity
{
    /**
     * @param string $name
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param Collection $items
     * @return void
     */
    public function setItems(Collection $items): void
    {
        $this->items = $items;
    }

    /**
     * @param string $type
     * @return void
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }
    /**
     * @param string $name
     * @param string $type
     */
    public function __construct()
    {
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return Collection
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    /**
     * @param AttributeValue $item
     * @return void
     */
    public function addItem(AttributeValue $item): void
    {
        $this->items->add($item);
    }

    /**
     * @ORM\Column(length=255)
     */
    private string $name;

    /**
     * @ORM\Column(length=52)
     */
    private string $type;

    /**
     * @ORM\OneToMany(
     *     mappedBy="attributeSet",
     *     targetEntity=AttributeValue::class,
     *     cascade={"persist", "remove"}
     * )
     */
    private Collection $items;
}
