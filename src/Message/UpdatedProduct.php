<?php

namespace App\Message;

use App\Entity\Product;

class UpdatedProduct extends ProductMessageFactory
{
    private Product $originalProduct;

    public function __construct(Product $product)
    {
        parent::__construct($product);
        $this->originalProduct = $product;
    }

    public function getOriginalProduct(): Product
    {
        return $this->originalProduct;
    }
}