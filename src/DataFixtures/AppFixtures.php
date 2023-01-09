<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function __construct()
    {
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

        $brands = $this->createEntitiesAndPersist('Brand', $brandCategoriesValues, $manager, 'code');
        $manager->flush();

        // Création des products
        $productsValues = [
            [
                'reference' => 'P-00001',
                'name' => 'Prixel 7 Pro - 256Go',
                'brand' => $brands['GOO'],
                'description' => 'Téléphone Google haut de gamme. Mémoire internet de 256 Go',
                'price' => 999,
            ], [
                'reference' => 'P-00002',
                'name' => 'Prixel 7 Pro - 128Go',
                'brand' => $brands['GOO'],
                'description' => 'Téléphone Google haut de gamme. Mémoire internet de 128 Go',
                'price' => 899,
            ], [
                'reference' => 'P-00002',
                'name' => 'Prixel 6a',
                'brand' => $brands['GOO'],
                'description' => 'Téléphone Google haut de gamme.',
                'price' => 459,
            ], [
                'reference' => 'P-00003',
                'name' => 'Xiaomi 12T Pro - Bleu, 8 GO + 256 GO',
                'brand' => $brands['XIA'],
                'description' => 'Téléphone Xiaomi haut de gamme.',
                'price' => 899.90,
            ], [
                'reference' => 'P-00004',
                'name' => 'Redmi Note 11 Pro+ 5G - Bleu étoilé, 6 GO + 128 GO',
                'brand' => $brands['XIA'],
                'description' => 'Téléphone Xiaomi haut de gamme.',
                'price' => 449.90,
            ]
        ];

        $this->createEntitiesAndPersist('Product', $productsValues, $manager);
        $manager->flush();
    }

    /**
     * Créer les entités à partir d'une liste associative.
     *
     * @return Collection<int, Entity>
     */
    private function createEntitiesAndPersist(string $entityName, array $entitiesValues, ObjectManager $objectManager, string $resultKey = null): array
    {
        $results = [];
        foreach ($entitiesValues as $entityFields) {
            $className = 'App\Entity\\' . $entityName;
            $item = new $className();
            foreach ($entityFields as $fieldName => $fieldValue) {
                // Si la valeur est un array, créer le sous - item 
                if ('array' === gettype($fieldValue)) {
                    $subEntityName = substr(ucfirst($fieldName), 0, -1);
                    $action = 'add' . $subEntityName;
                    $subItems = $this->createEntitiesAndPersist($subEntityName, $fieldValue, $objectManager);
                    foreach ($subItems as $subItem) {
                        $item->$action($subItem);
                    }
                } else {
                    $action = 'set' . ucfirst($fieldName);
                    if ('password' === $fieldName) {
                        // $item->$action($this->passwordHasher->hashPassword($item, $fieldValue));
                    } else {
                        $item->$action($fieldValue);
                    }
                }
            }
            $objectManager->persist($item);
            if (!empty($resultKey)) {
                $key = 'get' . ucfirst($resultKey);
                $results[$item->$key()] = $item;
            } else {
                $results[] = $item;
            }
        }

        return $results;
    }
}
