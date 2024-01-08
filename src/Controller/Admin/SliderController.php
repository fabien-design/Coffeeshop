<?php

namespace App\Controller\Admin;

use App\Repository\SliderRepository;

// use Symfony\Bundle\SecurityBundle\Security;
// use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
// use Symfony\Component\Security\Http\Attribute\IsGranted;
// use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
// use Symfony\Component\Security\Core\Exception\AuthenticationException;
// use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
// use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Validator\Validator\ValidatorInterface;

use App\Entity\Admin;
use App\Entity\Slider;
use App\Form\Type\SliderCreateType;
// use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SliderController extends AbstractController
{
    #[Route('/slider', name: 'admin_slider')]
    public function index(SliderRepository $sliderRepository): Response
    {
        $listSlide  = $sliderRepository->findAll();

        return $this->render('admin/slider_list.html.twig', [
            'controller_name' => 'DashboardController',
            'listSlide'      => $listSlide,
        ]);

    } 

    #[Route('/slider/create', name: 'admin_slider_create')]
    public function create(Request $request, SliderRepository $sliderRepository, ValidatorInterface $validator, EntityManagerInterface $entityManager): Response
    {
        $slider = new Slider();
        $form = $this->createForm(SliderCreateType::class, $slider);

        // Traiter la requête POST
        $form->handleRequest($request);

        // Vérifier si le formulaire a été soumis et est valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer les données du formulaire
            $formData = $form->getData();
            $errors = $validator->validate($formData);
            if (count($errors) > 0) {
                // Gérer les erreurs, par exemple, les afficher dans un message flash
                foreach ($errors as $error) {
                    $this->addFlash('error', $error->getMessage());
                }
    
                // Afficher à nouveau le formulaire avec les erreurs
                return $this->render('admin/slider/slider_create.html.twig', [
                    'form' => $form->createView(),
                ]);
            }
            // Faire quelque chose avec les données (par exemple, les sauvegarder en base de données)
            $entityManager->persist($formData);
            $entityManager->flush();

            $this->addFlash('success', "La slide a bien été ajoutée. ");
            // Rediriger ou afficher une réponse
            return $this->redirectToRoute('admin_slider');
        }

        // Si le formulaire n'a pas été soumis ou n'est pas valide, afficher le formulaire
        return $this->render('admin/slider/slider_create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/slider/edit/{id}', name: 'admin_slider_edit')]
    public function edit(Request $request, Slider $slider, ValidatorInterface $validator, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SliderCreateType::class, $slider);

        // Traiter la requête POST
        $form->handleRequest($request);

        // Vérifier si le formulaire a été soumis et est valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer les données du formulaire
            $formData = $form->getData();

            // Valider les données du formulaire
            $errors = $validator->validate($formData);

            if (count($errors) > 0) {
                // Gérer les erreurs, par exemple, les afficher dans un message flash
                foreach ($errors as $error) {
                    $this->addFlash('error', $error->getMessage());
                }

                // Afficher à nouveau le formulaire avec les erreurs
                return $this->render('admin/slider/slider_edit.html.twig', [
                    'form' => $form->createView(),
                    'slider' => $slider,
                ]);
            }

            // Mise à jour de l'entité avec les nouvelles données
            $entityManager->flush();

            $this->addFlash('success', "La slide a bien été modifiée.");

            // Rediriger ou afficher une réponse
            return $this->redirectToRoute('admin_slider');
        }

        // Si le formulaire n'a pas été soumis ou n'est pas valide, afficher le formulaire
        return $this->render('admin/slider/slider_edit.html.twig', [
            'form' => $form->createView(),
            'slider' => $slider,
        ]);
    }

    #[Route('/slider/delete/{id}', name: 'admin_slider_delete')]
    public function delete(Request $request, Slider $slider, ValidatorInterface $validator, EntityManagerInterface $entityManager): Response
    {
        $errors = $validator->validate($slider);

        if (count($errors) > 0) {
            // Gérer les erreurs, par exemple, les afficher dans un message flash
            foreach ($errors as $error) {
                $this->addFlash('error', $error->getMessage());
            }
            $this->addFlash('error', "La slide n'a pas réussi à être supprimée.");
            return $this->redirectToRoute('admin_slider');
        }

        // Mise à jour de l'entité avec les nouvelles données
        $entityManager->remove($slider);
        $entityManager->flush();

        $this->addFlash('success', "La slide a bien été supprimée.");

        // Rediriger ou afficher une réponse
        return $this->redirectToRoute('admin_slider');
        

        
    }
    

}
