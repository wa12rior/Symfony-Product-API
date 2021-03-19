<?php

namespace App\Entity;

use App\Entity\Traits\TimestampableEntity;
use App\Message\ProductMessageInterface;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
* @ORM\Entity(repositoryClass="ProductRepository")
 */
class Product
{
    use TimestampableEntity;

    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     */
    private string $id;

    /**
     * @ORM\Column()
     */
    private string $name;

    /**
     * @ORM\Column(nullable="true")
     */
    private ?string $description;

    /**
     * @ORM\Column()
     */
    private string $ptu;

    public function __construct(string $name, string $ptu, ?string $description = null)
    {
        $this->id = Uuid::uuid4();
        $this->name = $name;
        $this->ptu = $ptu;
        $this->description = $description;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getPtu(): string
    {
        return $this->ptu;
    }

    public function setPtu(string $ptu): void
    {
        $this->ptu = $ptu;
    }

    public function updateFromMessage(ProductMessageInterface $message): void
    {
        $this->name = $message->getName();
        $this->description = $message->getDescription();
        $this->ptu = $message->getPtu();
    }
}