<?php
namespace App\Form\Type;

use App\Entity\Slider;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface; 
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Validator\Constraints as Assert;

class SliderCreateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                "label" => "Titre",
                'constraints' => [
                new Assert\NotBlank(),
                new Assert\Length(['max' => 255]),
            ],])
            ->add('content', TextareaType::class, [
                "label" => "Contenu",
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['max' => 255]),
                ]])
            ->add('buttonText', TextType::class, [ "label" => "nom du bouton", "required" => false, 'constraints' => [
                new Assert\Length(['max' => 30]),
            ]])
            ->add('buttonLink', UrlType::class, [ "label" => "lien du bouton", "required" => false, 'constraints' => [
                new Assert\Length(['max' => 255]),
            ]])
            ->add('save', SubmitType::class, [ "label" => "Valider"])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            "data_class" => Slider::class,
        ]);

    }
}