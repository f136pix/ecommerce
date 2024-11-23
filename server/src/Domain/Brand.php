<?php

namespace App\Domain;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'brands')]
#[ORM\InheritanceType('SINGLE_TABLE')]
abstract class Brand extends BaseEntity
{
    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\OneToMany(mappedBy: 'brand', targetEntity: Product::class)]
    private Collection $products;
}
