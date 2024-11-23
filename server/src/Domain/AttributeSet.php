<?php

namespace App\Domain;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'attribute_sets')]
class AttributeSet extends BaseEntity
{
    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column(length: 50)]
    private string $type;

    #[ORM\OneToMany(
        mappedBy: 'attributeSet',
        targetEntity: AttributeValue::class,
        cascade: ['persist', 'remove']
    )]
    private Collection $items;
}
