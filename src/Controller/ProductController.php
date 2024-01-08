<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Product;
use App\Form\Type\ContactType;
use App\Repository\BrandRepository;
use App\Repository\CategoryRepository;
use App\Repository\FamilyRepository;
use App\Repository\ProductRepository;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends AbstractController
{

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    #[Route('/products', name: 'app_products')]
    public function index(ProductRepository $productRepository, CategoryRepository $categoryRepository, BrandRepository $brandRepository, FamilyRepository $familyRepository, Request $request,EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Le formulaire est valide, traitez les données ici (par exemple, envoyez un email).
            $contact = $form->getData();
            $entityManager->persist($contact);
            $entityManager->flush();
            $this->addFlash('success', 'Votre message a été envoyé avec succès.');

        }
        $limit = 9;
        $max = $productRepository->createQueryBuilder('p')
            ->select('count(p.id)')
            ->getQuery()
            ->getSingleScalarResult();

        $nbPages = ceil($max / $limit);

        if (!empty($request->query->get('page'))) {
            $page = (int)$request->query->getInt('page',1);
            if($page > $nbPages || $page <=0){
                throw $this->createNotFoundException('not_exist');
            }

            $offset = ($page - 1) * $limit;
            $criteria = [
                'limit' => $limit,
                'offset' => $offset,
            ];

            if ($page <= $nbPages) {
                $products = $productRepository->findWithPagination($limit, $offset);
            } else {
                $products = $productRepository->findWithPagination($limit, 0);
                $page = 1;
            }
        } else {
            $products = $productRepository->findWithPagination($limit, 0);
            $page = 1;
        }


        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
            'listCoffee'      => $products,
            'listCategories'  => $categoryRepository->findAll(),
            'listBrand'       => $brandRepository->findAll(),
            'listFamily'      => $familyRepository->findAll(),
            'paginationPages' => $nbPages,
            'currentPage'     => $page,
            'form'            => $form,
        ]);
    }

    #[Route('/products/filtered', name: 'productsFilters')]
    public function productWithFilter(Request $request, ProductRepository $productRepository, CategoryRepository $categoryRepository, BrandRepository $brandRepository, FamilyRepository $familyRepository, EntityManagerInterface $entityManager): Response
    {

        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Le formulaire est valide, traitez les données ici (par exemple, envoyez un email).
            $contact = $form->getData();
            $entityManager->persist($contact);
            $entityManager->flush();
            $this->addFlash('success', 'Votre message a été envoyé avec succès.');

        }

        $filters = [
            'categories' => $request->get('categorie'),
            'brand'      => $request->get('brand'),
            'family'     => $request->get('family'),
        ];

        
        $limit = 9;
        $productsFiltered = $productRepository->findByFiltersPagination($filters, $limit, 0);
        $max = count($productRepository->findByFilters($filters));
        $nbPages = ceil($max / $limit);

        if (!empty($request->query->get('page'))) {
            $page = (int)$request->query->getInt('page',1);
            if($page > $nbPages || $page <= 0){
                throw $this->createNotFoundException('not_exist');
            }
            $offset = ($page - 1) * $limit;
            $criteria = [
                'limit' => $limit,
                'offset' => $offset,
            ];

            if ($page <= $nbPages) {
                $productsFiltered = $productRepository->findByFiltersPagination($filters, $limit, $offset);
            } else {
                $productsFiltered = $productRepository->findByFiltersPagination($filters, $limit, 0);
                $page = 1;
            }
        } else {
            $productsFiltered = $productRepository->findByFiltersPagination($filters, $limit, 0);
            $page = 1;
        }

        return $this->render('product/index.html.twig', [
            'controller_name'   => 'ProductController',
            'listCoffee'        => $productsFiltered,
            'listCategories'    => $categoryRepository->findAll(),
            'listBrand'         => $brandRepository->findAll(),
            'listFamily'        => $familyRepository->findAll(),
            'paginationPages'   => $nbPages,
            'currentPage'       => $page,
            'form'              => $form
        ]);
    }
}
