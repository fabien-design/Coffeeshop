<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Product;

class ProductFixtures extends Fixture
{

    public const PRODUCTS = [
        [
            'name' => 'Lavazza',
            'price' => 3.99,
            'note' => 18,
            'best_seller' => true,
            'description' => 'A rich and aromatic coffee with a smooth finish.',
            'country' => 'Italy',
        ],
        [
            'name' => 'Illy coffee',
            'price' => 4.49,
            'note' => 16,
            'best_seller' => false,
            'description' => 'An Italian classic known for its bold flavor and quality.',
            'country' => 'Italy',
        ],
        [
            'name' => 'Arabica Gold',
            'price' => 5.99,
            'note' => 20,
            'best_seller' => true,
            'description' => 'Premium Arabica beans for a luxurious coffee experience.',
            'country' => 'Various',
        ],
        [
            'name' => 'Sumatra Blend',
            'price' => 6.99,
            'note' => 15,
            'best_seller' => false,
            'description' => 'A bold and earthy blend from the Indonesian archipelago.',
            'country' => 'Indonesia',
        ],
        [
            'name' => 'Brazilian Roast',
            'price' => 7.49,
            'note' => 17,
            'best_seller' => true,
            'description' => 'A medium-roast coffee with hints of chocolate and nuts.',
            'country' => 'Brazil',
        ],
        [
            'name' => 'Ethiopian Delight',
            'price' => 8.99,
            'note' => 19,
            'best_seller' => false,
            'description' => 'An exotic Ethiopian coffee with fruity and floral notes.',
            'country' => 'Ethiopia',
        ],
        [
            'name' => 'Colombian Supreme',
            'price' => 6.49,
            'note' => 16,
            'best_seller' => true,
            'description' => 'A smooth and well-balanced coffee from the Colombian highlands.',
            'country' => 'Colombia',
        ],
        [
            'name' => 'Java Joy',
            'price' => 5.49,
            'note' => 18,
            'best_seller' => false,
            'description' => 'A delightful coffee with a hint of Indonesian spice.',
            'country' => 'Indonesia',
        ],
        [
            'name' => 'Honduran Harmony',
            'price' => 7.99,
            'note' => 17,
            'best_seller' => true,
            'description' => 'A harmonious blend of Honduran beans for a balanced cup.',
            'country' => 'Honduras',
        ],
        [
            'name' => 'Mexican Mocha',
            'price' => 4.99,
            'note' => 15,
            'best_seller' => false,
            'description' => 'A chocolate-infused coffee with a hint of Mexican warmth.',
            'country' => 'Mexico',
        ],
        [
            'name' => 'Peruvian Passion',
            'price' => 8.49,
            'note' => 19,
            'best_seller' => true,
            'description' => 'A passionate blend of Peruvian coffee beans for a bold taste.',
            'country' => 'Peru',
        ],
        [
            'name' => 'Guatemalan Gourmet',
            'price' => 9.99,
            'note' => 20,
            'best_seller' => false,
            'description' => 'A gourmet coffee from Guatemala with complex and rich flavors.',
            'country' => 'Guatemala',
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::PRODUCTS as $attributes) {
            $product = new Product();
            $product->setName($attributes['name']);
            $product->setPrice($attributes['price']);
            $product->setNote($attributes['note']);
            $product->setBestSeller($attributes['best_seller']);
            $product->setDescription($attributes['description']);
            $product->setCountry($attributes['country']);

            // Randomly set the category

            switch (rand(0, 5)) {
                case 1:
                    $product->setCategory($this->getReference(CategoryFixtures::CA));
                    break;
                case 2:
                    $product->setCategory($this->getReference(CategoryFixtures::AM));
                    break;
                case 3:
                    $product->setCategory($this->getReference(CategoryFixtures::LA));
                    break;
                case 4:
                    $product->setCategory($this->getReference(CategoryFixtures::MO));
                    break;
                case 5:
                    $product->setCategory($this->getReference(CategoryFixtures::MA));
                    break;
                default:
                    $product->setCategory($this->getReference(CategoryFixtures::ES));
                    break;
            }

            // Randomly set the family

            switch (rand(0, 6)) {
                case 1:
                    $product->setFamily($this->getReference(FamilyFixtures::BO));
                    break;
                case 2:
                    $product->setFamily($this->getReference(FamilyFixtures::EP));
                    break;
                case 3:
                    $product->setFamily($this->getReference(FamilyFixtures::FL));
                    break;
                case 4:
                    $product->setFamily($this->getReference(FamilyFixtures::FJ));
                    break;
                case 5:
                    $product->setFamily($this->getReference(FamilyFixtures::FR));
                    break;
                case 6:
                    $product->setFamily($this->getReference(FamilyFixtures::GO));
                    break;
                default:
                    $product->setFamily($this->getReference(FamilyFixtures::AR));
                    break;
            }

            // Randomly set the brand

            switch (rand(0, 5)) {
                case 1:
                    $product->setBrand($this->getReference(BrandFixtures::NE));
                    break;
                case 2:
                    $product->setBrand($this->getReference(BrandFixtures::LA));
                    break;
                case 3:
                    $product->setBrand($this->getReference(BrandFixtures::ST));
                    break;
                case 4:
                    $product->setBrand($this->getReference(BrandFixtures::CR));
                    break;
                case 5:
                    $product->setBrand($this->getReference(BrandFixtures::PC));
                    break;
                default:
                    $product->setBrand($this->getReference(BrandFixtures::DU));
                    break;
            }


            $manager->persist($product);
        }

        $manager->flush();
    }
    


    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class, // Add CategoryFixtures to the dependencies array
            BrandFixtures::class,
            FamilyFixtures::class
        ];
    }

}
