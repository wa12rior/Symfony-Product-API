<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait TimestampableEntity
{
    /**
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected \DateTime $createdAt;

    /**
     * @ORM\Column(name="updated_at", type="datetime")
     */
    protected \DateTime $updatedAt;

    public function setCreatedAt($createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt($updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}