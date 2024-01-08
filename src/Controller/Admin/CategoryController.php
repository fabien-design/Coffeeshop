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

use App\Entity\Category;
use App\Form\Type\CategoryType;
use App\Repository\CategoryRepository;
// use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/categories', name: 'admin_categories')]
    public function index(CategoryRepository $categRepository ): Response
    {
        $listCateg  = $categRepository->findAll();

        return $this->render('admin/category/categories.html.twig', [
            'listCateg'      => $listCateg,
        ]);
       
    } 

    #[Route('/categories/create', name: 'admin_categories_create')]
    public function create(Request $request, CategoryRepository $categoryRepository, ValidatorInterface $validator, EntityManagerInterface $entityManager): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);

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
                return $this->render('admin/category/category_create.html.twig', [
                    'form' => $form->createView(),
                ]);
            }
            // Faire quelque chose avec les données (par exemple, les sauvegarder en base de données)
            $entityManager->persist($formData);
            $entityManager->flush();

            $this->addFlash('success', "Le produit a bien été ajoutée. ");
            // Rediriger ou afficher une réponse
            return $this->redirectToRoute('admin_categories');
        }

        // Si le formulaire n'a pas été soumis ou n'est pas valide, afficher le formulaire
        return $this->render('admin/category/category_create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/categories/edit/{id}', name: 'admin_categories_edit')]
    public function edit(Request $request, Category $category, ValidatorInterface $validator, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CategoryType::class, $category);

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
                return $this->render('admin/category/category_edit.html.twig', [
                    'form' => $form->createView(),
                    'category' => $category,
                ]);
            }

            // Mise à jour de l'entité avec les nouvelles données
            $entityManager->flush();

            $this->addFlash('success', "Le produit a bien été modifiée.");

            // Rediriger ou afficher une réponse
            return $this->redirectToRoute('admin_categories');
        }

        // Si le formulaire n'a pas été soumis ou n'est pas valide, afficher le formulaire
        return $this->render('admin/category/category_edit.html.twig', [
            'form' => $form->createView(),
            'category' => $category,
        ]);
    }

    #[Route('/categories/delete/{id}', name: 'admin_categories_delete')]
    public function delete(Request $request, Category $category, ValidatorInterface $validator, EntityManagerInterface $entityManager): Response
    {

        if (count($category->getProducts()) > 0) {
            $this->addFlash('error', "La catégorie ne peut pas être supprimée.");
            return $this->redirectToRoute('admin_categories');
        }
        
        $errors = $validator->validate($category);

        if (count($errors) > 0) {
            // Gérer les erreurs, par exemple, les afficher dans un message flash
            foreach ($errors as $error) {
                $this->addFlash('error', $error->getMessage());
            }
            $this->addFlash('error', "La catégorie n'a pas réussi à être supprimée.");
            return $this->redirectToRoute('admin_categories');
        }

        // Mise à jour de l'entité avec les nouvelles données
        $entityManager->remove($category);
        $entityManager->flush();

        $this->addFlash('success', "La catégorie a bien été supprimée.");

        // Rediriger ou afficher une réponse
        return $this->redirectToRoute('admin_categories');
        
        
    }
    

}
