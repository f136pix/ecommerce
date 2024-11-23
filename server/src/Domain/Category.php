<?php

namespace App\Domain;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'categories')]
#[ORM\InheritanceType('SINGLE_TABLE')]
abstract class Category extends BaseEntity
{
    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Product::class)]
    private Collection $products;

    public function __construct(string $name)
    {
        $this->$name = $name;
    }
}
