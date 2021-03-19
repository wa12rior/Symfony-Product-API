<?php

namespace App\Message;

use App\Entity\Product;
use App\Message\Factory\ProductMessageFactory;

class UpdatedProduct extends ProductMessageFactory
{
    private Product $originalProduct;

    public function __construct(Product $product, array $updatedValues)
    {
        $product->setName($updatedValues['name']);
        $product->setPtu($updatedValues['ptu']);
        $product->setDescription($updatedValues['description']);

        parent::__construct($product);
        $this->originalProduct = $product;
    }

    public function getOriginalProduct(): Product
    {
        return $this->originalProduct;
    }
}