<?php

namespace App\Domain\ProductsAggregate;

use App\Domain\BaseEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="products")
 * @ORM\InheritanceType("SINGLE_TABLE")
 */
class Product extends BaseEntity
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
     * @param string $description
     * @return void
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @param bool $inStock
     * @return void
     */
    public function setInStock(bool $inStock): void
    {
        $this->inStock = $inStock;
    }

    /**
     * @param float $price
     * @return void
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    /**
     * @param Collection $images
     * @return void
     */
    public function setImages(Collection $images): void
    {
        $this->images = $images;
    }

    /**
     * @param Collection $attributeValues
     * @return void
     */
    public function setAttributeValues(Collection $attributeValues): void
    {
        $this->attributeValues = $attributeValues;
    }

    /**
     *
     */
    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->attributeValues = new ArrayCollection();
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
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return bool
     */
    public function isInStock(): bool
    {
        return $this->inStock;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @return Collection
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    /**
     * @return Brand
     */
    public function getBrand(): Brand
    {
        return $this->brand;
    }

    /**
     * @return Category
     */
    public function getCategory(): Category
    {
        return $this->category;
    }

    /**
     * @return Collection
     */
    public function getAttributeValues(): Collection
    {
        return $this->attributeValues;
    }

    /**
     * @param Category $category
     * @return void
     */
    public function setCategory(Category $category): void
    {
        $this->category = $category;
    }

    /**
     * @param Brand $brand
     * @return void
     */
    public function setBrand(Brand $brand): void
    {
        $this->brand = $brand;
    }

    /**
     * @param ProductImage $image
     * @return void
     */
    public function addImage(ProductImage $image): void
    {
        $this->images->add($image);
    }

    /**
     * @ORM\Column(length=122)
     */
    private string $name;

    /**
     * @ORM\Column(length=3000)
     */
    private string $description;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $inStock = true;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private float $price;

    /**
     * @ORM\OneToMany(targetEntity=ProductImage::class, mappedBy="product")
     */
    private Collection $images;

    /**
     * @ORM\ManyToOne(targetEntity=Brand::class)
     */
    private Brand $brand;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class)
     */
    private Category $category;

    /**
     * @ORM\OneToMany(
     *     mappedBy="product",
     *     targetEntity=ProductAttributeValue::class,
     *     cascade={"persist", "remove"}
     * )
     */
    private Collection $attributeValues;
}
