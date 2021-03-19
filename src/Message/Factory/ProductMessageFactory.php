<?php

namespace App\Message\Factory;

use App\Entity\Product;
use App\Entity\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

class ProductMessageFactory implements ProductMessageInterface
{
    use TimestampableEntity;

    /**
     * @Assert\NotBlank()
     */
    private string $name;

    /**
     * @Assert\Length(max="200", maxMessage="Maksymalnie można wprowadzić 200 znaków", allowEmptyString=true)
     */
    private ?string $description;

    /**
     * @Assert\NotBlank()
     */
    private string $ptu;

    public function __construct(Product $product)
    {
        $this->name = $product->getName();
        $this->ptu = $product->getPtu();
        $this->description = $product->getDescription();
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

    public function createEntity(): Product
    {
        $product = new Product($this->name, $this->ptu);
        $product->setDescription($this->description);

        return $product;
    }
}