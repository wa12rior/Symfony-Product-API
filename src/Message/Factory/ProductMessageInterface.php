<?php

namespace App\Message;

use App\Entity\Product;

interface ProductMessageInterface
{
    public function getName(): string;

    public function getDescription(): ?string;

    public function getPtu(): string;

    public function createEntity(): Product;
}