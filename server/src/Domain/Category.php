<?php

namespace App\Domain;

use App\Domain\ProductsAggregate\Product;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="categories")
 * @ORM\InheritanceType("SINGLE_TABLE")
 */
#[ORM\Entity, ORM\Table(name: 'categories'), ORM\InheritanceType('SINGLE_TABLE')]
class Category extends BaseEntity
{
    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }
    public function getName(): string
    {
        return $this->name;
    }

    public function getProducts(): Collection
    {
        return $this->products;
    }
    /**
     * @ORM\Column(length=255)
     */
    #[ORM\Column(length: 255)]
    private string $name;

    /**
     * @ORM\OneToMany(mappedBy="category", targetEntity=Product::class)
     */
    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Product::class)]
    private Collection $products;
}
