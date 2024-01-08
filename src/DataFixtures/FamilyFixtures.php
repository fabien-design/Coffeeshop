<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Family;

class FamilyFixtures extends Fixture
{

    public const BO = 'FAMILY_BO';
    public const EP = 'FAMILY_EP';
    public const FL = 'FAMILY_FL';
    public const FJ = 'FAMILY_FJ';
    public const FR = 'FAMILY_FR';
    public const GO = 'FAMILY_GO';
    public const AR = 'FAMILY_AR';


    private const FAMILLES = [
        self::BO => ['name' => 'Boisé'],
        self::EP => ['name' => 'Épicée'],
        self::FL => ['name' => 'Florale'],
        self::FJ => ['name' => 'Fruits Jaunes'],
        self::FR => ['name' => 'Fruits Rouges'],
        self::GO => ['name' => 'Gourmande'],
        self::AR => ['name' => 'Aromatisé'],
    ];
    
    public function load(ObjectManager $manager): void
    {
        foreach ($this::FAMILLES as $code => $attributes) {
            $family = new Family();
            $family->setName($attributes['name']);
            $manager->persist($family);
            $this->addReference($code, $family);
        }

        $manager->flush();
    }
}
