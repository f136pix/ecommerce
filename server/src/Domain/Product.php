<?php

namespace App\Domain;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'products')]
#[ORM\InheritanceType('SINGLE_TABLE')]
abstract class Product extends BaseEntity
{
    #[ORM\Column(length: 122)]
    private string $name;


    #[ORM\Column(length: 255)]
    private string $description;

    #[ORM\Column(type: 'boolean')]
    private bool $inStock = true;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private float $price;

    #[ORM\OneToMany(targetEntity: ProductImage::class, mappedBy: 'product')]
    private Collection $images;

    #[ORM\ManyToOne(targetEntity: Brand::class)]
    private Brand $brand;

    #[ORM\ManyToOne(targetEntity: Category::class)]
    private Category $category;

    #[ORM\OneToMany(
        mappedBy: 'product',
        targetEntity: ProductAttributeValue::class,
        cascade: ['persist', 'remove']
    )]
    private Collection $attributeValues;

    public function __construct(string $name, float $price)
    {
        $this->name = $name;
        $this->price = $price;
    }

    abstract public function calculatePrice(): float;
}
