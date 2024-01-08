<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Repository\SliderRepository;


use App\Form\Type\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ProductRepository $productRepository, SliderRepository $sliderRepository, Request $request,EntityManagerInterface $entityManager): Response
    {

        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);

        $listCoffee = $productRepository->findBy(['bestSeller' => 1]);
        $listSlide  = $sliderRepository->findAll();

        
        if ($form->isSubmitted() && $form->isValid()) {
            // Le formulaire est valide, traitez les données ici (par exemple, envoyez un email).
            $contact = $form->getData();
            $entityManager->persist($contact);
            $entityManager->flush();
            $this->addFlash('success', 'Votre message a été envoyé avec succès.');

            // Redirigez l'utilisateur ou effectuez une autre action.
            return $this->render('home/index.html.twig', [
                'controller_name' => 'HomeController',
                'listCoffee'      => $listCoffee,
                'listSlide'      => $listSlide,
                'form' => $form->createView(),
            ]);
        }


        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'listCoffee'      => $listCoffee,
            'listSlide'      => $listSlide,
            'form' => $form->createView(),
        ]);
    }
}
