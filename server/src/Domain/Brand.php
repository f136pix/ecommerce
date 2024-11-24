<?php

namespace App\Domain;

use App\Domain\ProductsAggregate\Product;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="brands")
 * @ORM\InheritanceType("SINGLE_TABLE")
 */
#[ORM\Entity, ORM\Table(name: 'brands'), ORM\InheritanceType('SINGLE_TABLE')]
class Brand extends BaseEntity
{
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function getName(): string
    {
        return $this->name;
    }
    /**
     * @ORM\Column(length=255)
     */
    #[ORM\Column(length: 255)]
    private string $name;

    /**
     * @ORM\OneToMany(mappedBy="brand", targetEntity=Product::class)
     */
    #[ORM\OneToMany(mappedBy: 'brand', targetEntity: Product::class)]
    private Collection $products;
}