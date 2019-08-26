<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ProductFixture extends Fixture
{
    CONST MAX_PRODUCTS = 100;

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < self::MAX_PRODUCTS; $i++) {
            $product = new Product();
            $product->setName('product №'.$i);
            $product->setPrice(rand(100,1000));
            $manager->persist($product);
        }
        $manager->flush();
    }
}
