<?php

namespace App\Domain;

use App\Entity\ArrayCollection;
use App\Entity\Category;
use App\Entity\Collection;
use App\Entity\ProductAttribute;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'products_images')]
#[ORM\InheritanceType('SINGLE_TABLE')]
abstract class ProductImage extends BaseEntity
{
    #[ORM\Column(length: 255)]
    private string $url;

    #[ORM\Column(type: 'integer')]
    private string $position;

    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'images')]
    private Product $product;

    public function __construct(string $url, int $position)
    {
        $this->url = $url;
        $this->$position = $position;
    }
}
