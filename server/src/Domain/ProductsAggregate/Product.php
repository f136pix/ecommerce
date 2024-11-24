<?php

namespace App\Domain\ProductsAggregate;

use App\Domain\BaseEntity;
use App\Domain\Brand;
use App\Domain\Category;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="products")
 * @ORM\InheritanceType("SINGLE_TABLE")
 */
#[ORM\Entity, ORM\Table(name: 'products'), ORM\InheritanceType('SINGLE_TABLE')]
class Product extends BaseEntity
{
    public function __construct(
        string $name,
        string $description,
        bool   $inStock,
        float  $price,
    )
    {
        $this->name = $name;
        $this->description = $description;
        $this->inStock = $inStock;
        $this->price = $price;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function isInStock(): bool
    {
        return $this->inStock;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getImages(): Collection
    {
        return $this->images;
    }

    public function getBrand(): Brand
    {
        return $this->brand;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function getAttributeValues(): Collection
    {
        return $this->attributeValues;
    }

    public function setCategory(Category $category): void
    {
        $this->category = $category;
    }

    /**
     * @param Brand $brand
     */
    public function setBrand(Brand $brand): void
    {
        $this->brand = $brand;
    }

    public function addImage(ProductImage $image): void
    {
        $this->images->add($image);
    }

    /**
     * @ORM\Column(length=122)
     */
    #[ORM\Column(length: 122)]
    private string $name;

    /**
     * @ORM\Column(length=3000)
     */
    #[ORM\Column(length: 3000)]
    private string $description;

    /**
     * @ORM\Column(type="boolean")
     */
    #[ORM\Column(type: 'boolean')]
    private bool $inStock = true;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private float $price;

    /**
     * @ORM\OneToMany(targetEntity=ProductImage::class, mappedBy="product")
     */
    #[ORM\OneToMany(targetEntity: ProductImage::class, mappedBy: 'product')]
    private Collection $images;

    /**
     * @ORM\ManyToOne(targetEntity=Brand::class)
     */
    #[ORM\ManyToOne(targetEntity: Brand::class)]
    private Brand $brand;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class)
     */
    #[ORM\ManyToOne(targetEntity: Category::class)]
    private Category $category;

    /**
     * @ORM\OneToMany(
     *     mappedBy="product",
     *     targetEntity=ProductAttributeValue::class,
     *     cascade={"persist", "remove"}
     * )
     */
    #[ORM\OneToMany(
        mappedBy: 'product',
        targetEntity: ProductAttributeValue::class,
        cascade: ['persist', 'remove']
    )]
    private Collection $attributeValues;
}
