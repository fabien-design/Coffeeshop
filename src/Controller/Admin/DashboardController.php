<?php

namespace App\Controller\Admin;


use App\Repository\BrandRepository;
use App\Repository\CategoryRepository;
use App\Repository\AdminRepository;
use App\Repository\ContactRepository;
use App\Repository\ProductRepository;
use App\Repository\SliderRepository;

use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

use App\Entity\Admin;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/', name: 'admin_index')]
    public function index( ): Response
    {
       return $this->redirectToRoute('admin_products');
    } 
   

    #[Route('/contacts', name: 'admin_contacts')]
    public function contactsDashboard(ContactRepository $contactRepository ): Response
    {
        $listContact  = $contactRepository->findAll();

        return $this->render('admin/contact_list.html.twig', [
            'controller_name' => 'DashboardController',
            'listContacts'      => $listContact,
        ]);;
       
    } 

}
