<?php

namespace App\Domain\ProductsAggregate;

use App\Domain\BaseEntity;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="categories")
 * @ORM\InheritanceType("SINGLE_TABLE")
 */
class Category extends BaseEntity
{
    /**
     *
     */
    public function __construct()
    {
    }

    /**
     * @param string $name
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Collection
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    /**
     * @ORM\Column(length=255)
     */
    private string $name;

    /**
     * @ORM\OneToMany(mappedBy="category", targetEntity=Product::class)
     */
    private Collection $products;
}
