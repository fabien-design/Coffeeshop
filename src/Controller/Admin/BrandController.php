<?php

namespace App\Controller\Admin;

// use Symfony\Bundle\SecurityBundle\Security;
// use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
// use Symfony\Component\Security\Http\Attribute\IsGranted;
// use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
// use Symfony\Component\Security\Core\Exception\AuthenticationException;
// use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
// use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Validator\Validator\ValidatorInterface;

use App\Entity\Admin;
use App\Entity\Brand;
use App\Form\Type\BrandType;
use App\Repository\BrandRepository;
use App\Repository\CategoryRepository;
use App\Repository\SliderRepository;
// use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Length;

class BrandController extends AbstractController
{
    #[Route('/brands', name: 'admin_brands')]
    public function index(BrandRepository $brandRepository): Response
    {
        //$this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
        $listBrand  = $brandRepository->findAll();


        return $this->render('admin/brand/brands.html.twig', [
            'listBrand'      => $listBrand,
        ]);
    } 

    #[Route('/brands/create', name: 'admin_brands_create')]
    public function create(Request $request, BrandRepository $brandRepository, ValidatorInterface $validator, EntityManagerInterface $entityManager): Response
    {
        $brand = new Brand();
        $form = $this->createForm(BrandType::class, $brand);

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
                return $this->render('admin/brand/brand_create.html.twig', [
                    'form' => $form->createView(),
                ]);
            }
            // Faire quelque chose avec les données (par exemple, les sauvegarder en base de données)
            $entityManager->persist($formData);
            $entityManager->flush();

            $this->addFlash('success', "Le produit a bien été ajoutée. ");
            // Rediriger ou afficher une réponse
            return $this->redirectToRoute('admin_brands');
        }

        // Si le formulaire n'a pas été soumis ou n'est pas valide, afficher le formulaire
        return $this->render('admin/brand/brand_create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/brands/edit/{id}', name: 'admin_brands_edit')]
    public function edit(Request $request, Brand $brand, ValidatorInterface $validator, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BrandType::class, $brand);

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
                return $this->render('admin/brand/brand_edit.html.twig', [
                    'form' => $form->createView(),
                    'brand' => $brand,
                ]);
            }

            // Mise à jour de l'entité avec les nouvelles données
            $entityManager->flush();

            $this->addFlash('success', "Le produit a bien été modifiée.");

            // Rediriger ou afficher une réponse
            return $this->redirectToRoute('admin_brands');
        }

        // Si le formulaire n'a pas été soumis ou n'est pas valide, afficher le formulaire
        return $this->render('admin/brand/brand_edit.html.twig', [
            'form' => $form->createView(),
            'brand' => $brand,
        ]);
    }

    #[Route('/brands/delete/{id}', name: 'admin_brands_delete')]
    public function delete(Request $request, Brand $brand, ValidatorInterface $validator, EntityManagerInterface $entityManager): Response
    {

        if (count($brand->getProducts()) > 0) {
            $this->addFlash('error', "La marque ne peut pas être supprimée.");
            return $this->redirectToRoute('admin_brands');
        }
        
        $errors = $validator->validate($brand);

        if (count($errors) > 0) {
            // Gérer les erreurs, par exemple, les afficher dans un message flash
            foreach ($errors as $error) {
                $this->addFlash('error', $error->getMessage());
            }
            $this->addFlash('error', "Le produit n'a pas réussi à être supprimée.");
            return $this->redirectToRoute('admin_brands');
        }

        // Mise à jour de l'entité avec les nouvelles données
        $entityManager->remove($brand);
        $entityManager->flush();

        $this->addFlash('success', "Le produit a bien été supprimée.");

        // Rediriger ou afficher une réponse
        return $this->redirectToRoute('admin_brands');
        
        
    }
    

}
