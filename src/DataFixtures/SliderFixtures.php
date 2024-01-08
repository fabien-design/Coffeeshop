<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Contact;

class SliderFixtures extends Fixture
{
    public const S1 = 'SLIDER_S1';
    public const S2 = 'SLIDER_S2';
    public const S3 = 'SLIDER_S3';
    public const SLIDER = [
        self::S1 => ['title' => 'Je sais pas', 'descript' => 'je ne sais pas quoi mettre mais le café est bon'],
        self::S2 => ['title' => 'Artisanal','descript' => 'Les cafés sont fait maisons.'],
        self::S3 => ['title' => 'Perfection', 'descript' => 'Les cafés sont fait maisons et très bien fait.'],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach ($this::SLIDER as $code => $attributes) {
            $slider = new Slider();
            $slider->setTitle($attributes['title']);
            $slider->setContent($attributes['descript']);

            if(rand(0,1) === 1){
                $slider->setButtonText("Click here ".rand(1,3));
                $slider->setButtonLink("#");
            }

            $manager->persist($slider);

        }
        $manager->flush();
    }
}