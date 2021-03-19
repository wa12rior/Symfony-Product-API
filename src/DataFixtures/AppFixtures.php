<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
         $product = new Product('Test name', 'P43234', 'Test description');
         $this->addReference('test_product_1', $product);
         $manager->persist($product);

        $manager->flush();
    }
}
