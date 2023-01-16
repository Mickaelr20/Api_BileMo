<?php

namespace App\DataFixtures;

use App\Entity\Brand;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Product;
use Faker\Factory;

class AppFixtures extends Fixture
{
    private $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager): void
    {
        // Création des catégories des marques : Brand
        $brandCategoriesValues = [
            [
                'name' => 'Google',
                'code' => 'GOO'
            ], [
                'name' => 'Xiaomi',
                'code' => 'XIA'
            ], [
                'name' => 'Samsung',
                'code' => 'SAM'
            ], [
                'name' => 'Apple',
                'code' => 'APL'
            ], [
                'name' => 'Razer',
                'code' => 'RZR'
            ], [
                'name' => 'LG',
                'code' => 'LG'
            ],
        ];

        for ($i = 0; $i < 10; $i++) {
            $brand = new Brand();
            $brand->setCode("BR" . $i);
            $name = $this->faker->word();
            echo $name;
            $brand->setName($name);
            $manager->persist($brand);

            $product = new Product();
            $product->setReference('P-' . str_pad($i, 5, "0", STR_PAD_LEFT));
            $product->setName($this->faker->words(3, true));
            $product->setBrand($brand);
            $product->setDescription($this->faker->paragraph());
            $product->setPrice($this->faker->randomNumber(3, false));
            $manager->persist($product);
        }

        $manager->flush();
    }
}
