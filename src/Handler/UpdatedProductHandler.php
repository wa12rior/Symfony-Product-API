<?php

namespace App\Handler;

use App\Message\UpdatedProduct;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class UpdatedProductHandler implements MessageHandlerInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke(UpdatedProduct $updatedProduct)
    {
        $originalProduct = $updatedProduct->getOriginalProduct();
        $originalProduct->updateFromMessage($updatedProduct);

        $this->entityManager->flush();
    }
}