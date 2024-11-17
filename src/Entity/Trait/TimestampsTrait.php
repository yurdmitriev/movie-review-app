<?php

namespace App\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

trait TimestampsTrait
{
    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;
    #[ORM\Column]
    private ?\DateTimeImmutable $modifiedAt = null;

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getModifiedAt(): ?\DateTimeImmutable
    {
        return $this->modifiedAt;
    }

    #[ORM\PrePersist]
    public function beforeCreate(): void
    {
        $datetime = new \DateTimeImmutable();
        list($this->createdAt, $this->modifiedAt) = [$datetime, $datetime];
    }

    #[ORM\PreUpdate]
    public function beforeUpdate(): void
    {
        $this->modifiedAt = new \DateTimeImmutable();
    }
}