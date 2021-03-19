<?php

namespace App\Handler;

use App\Entity\Product;
use App\Message\NewProduct;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class NewProductHandler implements MessageHandlerInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke(NewProduct $product)
    {
        $newProduct = new Product($product->getName(), $product->getPtu(), $product->getDescription());

        $this->entityManager->persist($newProduct);
        $this->entityManager->flush();
    }
}