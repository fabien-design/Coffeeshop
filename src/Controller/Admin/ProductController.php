<?php

namespace App\Controller\Admin;

use App\Repository\ProductRepository;

// use Symfony\Bundle\SecurityBundle\Security;
// use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
// use Symfony\Component\Security\Http\Attribute\IsGranted;
// use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
// use Symfony\Component\Security\Core\Exception\AuthenticationException;
// use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
// use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Validator\Validator\ValidatorInterface;

use App\Entity\Admin;
use App\Entity\Product;
use App\Entity\Slider;
use App\Form\Type\ProductType;
use App\Form\Type\SliderCreateType;
use App\Repository\BrandRepository;
use App\Repository\CategoryRepository;
use App\Repository\SliderRepository;
// use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/products', name: 'admin_products')]
    public function index(ProductRepository $productRepository, SliderRepository $sliderRepository,BrandRepository $brandRepository, CategoryRepository $categRepository ): Response
    {
        //$this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
        $listCoffee = $productRepository->findAll();
        $listSlide  = $sliderRepository->findAll();
        $listBrand = $brandRepository->findAll();
        $listCateg  = $categRepository->findAll();

        return $this->render('admin/products.html.twig', [
            'controller_name' => 'DashboardController',
            'listCoffee'      => $listCoffee,
            'listSlide'      => $listSlide,
            'listBrand'      => $listBrand,
            'listCateg'      => $listCateg
        ]);
    } 

    #[Route('/products/create', name: 'admin_product_create')]
    public function create(Request $request, ProductRepository $productRepository, ValidatorInterface $validator, EntityManagerInterface $entityManager): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);

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
                return $this->render('admin/product/product_create.html.twig', [
                    'form' => $form->createView(),
                ]);
            }
            // Faire quelque chose avec les données (par exemple, les sauvegarder en base de données)
            $entityManager->persist($formData);
            $entityManager->flush();

            $this->addFlash('success', "Le produit a bien été ajoutée. ");
            // Rediriger ou afficher une réponse
            return $this->redirectToRoute('admin_products');
        }

        // Si le formulaire n'a pas été soumis ou n'est pas valide, afficher le formulaire
        return $this->render('admin/product/product_create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/products/edit/{id}', name: 'admin_product_edit')]
    public function edit(Request $request, Product $product, ValidatorInterface $validator, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProductType::class, $product);

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
                return $this->render('admin/product/product_edit.html.twig', [
                    'form' => $form->createView(),
                    'product' => $product,
                ]);
            }

            // Mise à jour de l'entité avec les nouvelles données
            $entityManager->flush();

            $this->addFlash('success', "Le produit a bien été modifiée.");

            // Rediriger ou afficher une réponse
            return $this->redirectToRoute('admin_products');
        }

        // Si le formulaire n'a pas été soumis ou n'est pas valide, afficher le formulaire
        return $this->render('admin/product/product_edit.html.twig', [
            'form' => $form->createView(),
            'product' => $product,
        ]);
    }

    #[Route('/product/delete/{id}', name: 'admin_product_delete')]
    public function delete(Request $request, Product $product, ValidatorInterface $validator, EntityManagerInterface $entityManager): Response
    {
        $errors = $validator->validate($product);

        if (count($errors) > 0) {
            // Gérer les erreurs, par exemple, les afficher dans un message flash
            foreach ($errors as $error) {
                $this->addFlash('error', $error->getMessage());
            }
            $this->addFlash('error', "Le produit n'a pas réussi à être supprimée.");
            return $this->redirectToRoute('admin_products');
        }

        // Mise à jour de l'entité avec les nouvelles données
        $entityManager->remove($product);
        $entityManager->flush();

        $this->addFlash('success', "Le produit a bien été supprimée.");

        // Rediriger ou afficher une réponse
        return $this->redirectToRoute('admin_products');
        
        
    }
    

}
