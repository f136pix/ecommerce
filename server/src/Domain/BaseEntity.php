<?php

namespace App\Domain;

use Doctrine\ORM\Mapping as ORM;

#[ORM\MappedSuperclass]
abstract class BaseEntity
{
    #[ORM\Column]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Id]
    private string $id;

    public function getId(): string
    {
        return $this->id;
    }
}
