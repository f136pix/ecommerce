<?php

namespace App\Domain\ProductsAggregate;

use App\Domain\BaseEntity;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="attribute_sets")
 */
#[ORM\Entity, ORM\Table(name: 'attribute_sets')]
class AttributeSet extends BaseEntity
{
    /**
     * @param string $name
     * @param string $type
     */
    public function __construct(string $name, string $type)
    {
        $this->name = $name;
        $this->type = $type;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(AttributeValue $item): void
    {
        $this->items->add($item);
    }

    /**
     * @ORM\Column(length=255)
     */
    #[ORM\Column(length: 255)]
    private string $name;

    /**
     * @ORM\Column(length=52)
     */
    #[ORM\Column(length: 52)]
    private string $type;

    /**
     * @ORM\OneToMany(
     *     mappedBy="attributeSet",
     *     targetEntity=AttributeValue::class,
     *     cascade={"persist", "remove"}
     * )
     */
    #[ORM\OneToMany(
        mappedBy: 'attributeSet',
        targetEntity: AttributeValue::class,
        cascade: ['persist', 'remove']
    )]
    private Collection $items;
}
