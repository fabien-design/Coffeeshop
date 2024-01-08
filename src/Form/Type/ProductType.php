<?php
namespace App\Form\Type;

use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Intl\Countries;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $isEdit = $options['data'] ?? null;

        $countries = Countries::getNames();
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'required' => true,
            ])
            ->add('Description', TextareaType::class, [
                'label' => 'Description',
                'required' => true,
            ])
            ->add('price', NumberType::class, [
                'label' => 'Prix',
                'required' => true,
                'scale' => 2, // Assuming you want a floating-point number with 2 decimal places
            ])
            ->add('Note', NumberType::class, [
                'label' => 'Note',
                'required' => true,
                'scale' => 0, // Assuming you want an integer rating
            ])
            ->add('Family', EntityType::class, [
                'class' => 'App\Entity\Family',
                'label' => 'Famille',
                'required' => true,
                'choice_label' => 'name', // Assuming 'name' is the property you want to display
            ])
            ->add('brand', EntityType::class, [
                'class' => 'App\Entity\Brand',
                'label' => 'Marque',
                'required' => true,
                'choice_label' => 'name',
            ])
            ->add('category', EntityType::class, [
                'class' => 'App\Entity\Category',
                'label' => 'Catégorie',
                'required' => true,
                'choice_label' => 'name',
            ])
            ->add('country', CountryType::class, [
                'label' => 'Pays',
                'required' => true,
                'choices' => array_flip($countries),
            ])
            ->add('bestSeller', CheckboxType::class, [
                'label' => 'Best Seller',
                'required' => false,
            ])
            ->add('submit', SubmitType::class,[
                'label' => $isEdit ? 'Modifier' : 'Ajouter',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
            "allow_extra_fields" => true
        ]);
    }
}