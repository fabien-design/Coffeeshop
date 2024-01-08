<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\Type\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(): Response
    {
        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
        ]);
    }

    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $entity = new Contact();
        $form = $this->createForm(ContactType::class, $entity);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Persistez les données en base de données
            $entityManager->persist($entity);
            $entityManager->flush();

            // Ajoutez un message flash ou redirigez l'utilisateur vers une autre page
        }

        return $this->render('votre_template.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
