<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Brand;

class BrandFixtures extends Fixture
{

    public const NE = 'CATEGORY_NE';
    public const LA = 'CATEGORY_LA';
    public const ST = 'CATEGORY_ST';
    public const CR = 'CATEGORY_CR';
    public const PC = 'CATEGORY_PC';
    public const DU = 'CATEGORY_DU';

    private const BRAND = [
        self::NE => ['name' => 'Nespresso'],
        self::LA => ['name' => 'Lavazza'],
        self::ST => ['name' => 'Starbucks'],
        self::CR => ['name' => 'Coffee Republic'],
        self::PC => ['name' => 'Peet\'s Coffee'],
        self::DU => ['name' => 'Dunkin\''],
    ];


    public function load(ObjectManager $manager): void
    {
        foreach ($this::BRAND as $code => $bd) {
            $brand = new Brand();
            $brand->setName($bd['name']);
            $manager->persist($brand);
            $this->addReference($code, $brand);
        }

        $manager->flush();
    }
}
