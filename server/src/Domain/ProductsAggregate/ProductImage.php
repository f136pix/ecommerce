<?php

namespace App\Domain\ProductsAggregate;

use App\Domain\BaseEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="products_images")
 * @ORM\InheritanceType("SINGLE_TABLE")
 */
#[ORM\Entity, ORM\Table(name: 'products_images'), ORM\InheritanceType('SINGLE_TABLE')]
class ProductImage extends BaseEntity
{
    public function getUrl(): string
    {
        return $this->url;
    }

    public function getPosition(): int
    {
        return $this->position;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }
    /**
     * @ORM\Column(length=255)
     */
    #[ORM\Column(length: 255)]
    private string $url;

    /**
     * @ORM\Column(type="integer")
     */
    #[ORM\Column(type: 'integer')]
    private int $position;

    /**
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="images", cascade={"persist"})
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    #[ORM\ManyToOne(
        targetEntity: Product::class,
        cascade: ['persist'],
        inversedBy: 'images'
    ), ORM\JoinColumn(name: 'product_id', referencedColumnName: 'id')]
    private Product $product;

    public function __construct(string $url, int $position, Product $product)
    {
        $this->url = $url;
        $this->position = $position;
        $this->product = $product;
    }
}
