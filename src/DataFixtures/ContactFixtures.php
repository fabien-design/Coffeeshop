<?php

namespace App\DataFixtures;

use App\Entity\Contact;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
;

class ContactFixtures extends Fixture
{
    public const C1 = 'CONTACT_C1';
    public const C2 = 'CONTACT_C2';
    public const C3 = 'CONTACT_C3';
    public const C4 = 'CONTACT_C4';
    public const C5 = 'CONTACT_C5';
    public const C6 = 'CONTACT_C6';
    public const C7 = 'CONTACT_C7';
    public const C8 = 'CONTACT_C8';
    public const C9 = 'CONTACT_C9';

    public const CONTACT = [
        self::C1 => [
            'firstname' => 'Jean',
            'lastname' => 'Bonbeur',
            'email' => 'jean.bonbeur@gmail.com',
            'phone' => '+330674140175',
            'message' => 'Bonjour, je suis intéressé par vos produits.',
        ],
        self::C2 => [
            'firstname' => 'Marie',
            'lastname' => 'Dupont',
            'email' => 'marie.dupont@gmail.com',
            'phone' => '+330674140176',
            'message' => 'Je voudrais commander un café.',
        ],
        self::C3 => [
            'firstname' => 'Pierre',
            'lastname' => 'Martin',
            'email' => 'pierre.martin@gmail.com',
            'phone' => '+330674140177',
            'message' => 'J\'ai un problème avec ma commande.',
        ],
        self::C4 => [
            'firstname' => 'Audrey',
            'lastname' => 'Laroche',
            'email' => 'audrey.laroche@gmail.com',
            'phone' => '+330674140178',
            'message' => 'Je souhaite vous faire part de mon avis sur vos produits.',
        ],
        self::C5 => [
            'firstname' => 'Thomas',
            'lastname' => 'Moreau',
            'email' => 'thomas.moreau@gmail.com',
            'phone' => '+330674140179',
            'message' => 'J\'ai une question sur vos conditions de livraison.',
        ],
        self::C6 => [
            'firstname' => 'Sophie',
            'lastname' => 'Dubois',
            'email' => 'sophie.dubois@gmail.com',
            'phone' => '+330674140180',
            'message' => 'Je souhaite vous faire une suggestion pour améliorer vos produits.',
        ],
        self::C7 => [
            'firstname' => 'Marc',
            'lastname' => 'Bernard',
            'email' => 'marc.bernard@gmail.com',
            'phone' => '+330674140181',
            'message' => 'Je voudrais postuler à un emploi chez vous.',
        ],
        self::C8 => [
            'firstname' => 'Céline',
            'lastname' => 'Robert',
            'email' => 'celine.robert@gmail.com',
            'phone' => '+330674140182',
            'message' => 'J\'ai un problème avec mon compte.',
        ],
        self::C9 => [
            'firstname' => 'Luc',
            'lastname' => 'Martinez',
            'email' => 'luc.martinez@gmail.com',
            'phone' => '+330674140183',
            'message' => 'Je voudrais faire une réclamation.',
        ],
    ];


    public function load(ObjectManager $manager): void
    {
        foreach ($this::CONTACT as $code => $attributes) {
            $contact = new Contact();
            $contact->setFirstName($attributes['firstname']);
            $contact->setFirstName($attributes['firstname']);
            $contact->setLastName($attributes['lastname']);
            $contact->setEmail($attributes['email']);
            $contact->setPhone($attributes['phone']);
            $contact->setMessage($attributes['message']);
            $manager->persist($contact);

        }

        $manager->flush();
    }
}
