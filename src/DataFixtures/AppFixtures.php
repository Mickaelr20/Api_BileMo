<?php

namespace App\DataFixtures;

use App\Entity\Brand;
use App\Entity\Client;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Product;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $faker;
    public const DEFAULT_USER_EMAIL = 'mickaelr20@gmail.com';
    public const DEFAULT_USER_PASSWORD = 'azerty';

    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 25; ++$i) {
            $brand = new Brand();
            $brand->setCode('BR' . $i);
            $name = $this->faker->word();
            $brand->setName($name);
            $manager->persist($brand);

            $product = new Product();
            $product->setReference('P-' . str_pad($i, 5, '0', STR_PAD_LEFT));
            $product->setName($this->faker->words(3, true));
            $product->setBrand($brand);
            $product->setDescription($this->faker->sentence(15));
            $product->setPrice($this->faker->randomNumber(3, false));
            $manager->persist($product);
        }

        $client = new Client();
        $client->setEmail(self::DEFAULT_USER_EMAIL);
        $client->setPassword($this->passwordHasher->hashPassword($client, self::DEFAULT_USER_PASSWORD));
        $manager->persist($client);

        for ($i = 0; $i < 3; $i++) {
            $randomUser = new User();
            $randomUser->setFirstName($this->faker->firstName());
            $randomUser->setLastName($this->faker->LastName());
            $randomUser->setEmail($this->faker->Email());
            $randomUser->setClient($client);
            $manager->persist($randomUser);
        }

        for ($i = 0; $i < 3; $i++) {
            $randomClient = new Client();
            $randomClient->setEmail($this->faker->email());
            $randomClient->setPassword($this->passwordHasher->hashPassword($randomClient, $this->faker->password()));
            $manager->persist($randomClient);

            for ($i = 0; $i < 3; $i++) {
                $randomUser = new User();
                $randomUser->setFirstName($this->faker->firstName());
                $randomUser->setLastName($this->faker->LastName());
                $randomUser->setEmail($this->faker->Email());
                $randomUser->setClient($randomClient);
                $manager->persist($randomUser);
            }
        }


        $manager->flush();
    }
}
