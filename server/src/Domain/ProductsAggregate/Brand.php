<?php

namespace App\Domain\ProductsAggregate;

use App\Domain\BaseEntity;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="brands")
 * @ORM\InheritanceType("SINGLE_TABLE")
 */
class Brand extends BaseEntity
{
    /**
     *
     */
    public function __construct()
    {
    }

    /**
     * @return Collection
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    /**
     * @param string $name
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
     * @ORM\Column(length=255)
     */
    private string $name;

    /**
     * @ORM\OneToMany(mappedBy="brand", targetEntity=Product::class)
     */
    private Collection $products;
}
