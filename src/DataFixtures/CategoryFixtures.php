<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Category;

class CategoryFixtures extends Fixture
{

    public const ES = 'CATEGORY_ES';
    public const CA = 'CATEGORY_CA';
    public const AM = 'CATEGORY_AM';
    public const LA = 'CATEGORY_LA';
    public const MO = 'CATEGORY_MO';
    public const MA = 'CATEGORY_MA';

    private const CATEGORIES = [
        self::ES => ['name' => 'Espresso'],
        self::CA => ['name' => 'Cappuccino'],
        self::AM => ['name' => 'Americano'],
        self::LA => ['name' => 'Latte'],
        self::MO => ['name' => 'Mocha'],
        self::MA => ['name' => 'Macchiato'],
    ];
    


    public function load(ObjectManager $manager): void
    {
        foreach ($this::CATEGORIES as $code => $attributes) {
            $category = new Category();
            $category->setName($attributes['name']);

            $manager->persist($category);

            $this->addReference($code, $category);
        }

        $manager->flush();
    }
}
