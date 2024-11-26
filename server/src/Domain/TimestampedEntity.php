<?php

namespace App\Domain;

use Cassandra\Date;
use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * @ORM\MappedSuperclass
 * @ORM\HasLifecycleCallbacks
 */
#[ORM\MappedSuperclass, ORM\HasLifecycleCallbacks]
class TimestampedEntity extends BaseEntity
{
    /**
     * @ORM\Column(type="datetime")
     */
    #[ORM\Column(type: 'datetime')]
    public DateTime $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    #[ORM\Column(type: 'datetime')]
    public ?DateTime $updatedAt;

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt = new DateTime()): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTime $updatedAt = new DateTime()): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @ORM\PrePersist
     */
    #[ORM\PrePersist]
    public function onPrePersist(): void
    {
        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();
    }

    /**
     * @ORM\PreUpdate
     */
    #[ORM\PreUpdate]
    public function onPreUpdate(): void
    {
        $this->updatedAt = new DateTime();
    }
}