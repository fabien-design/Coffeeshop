<?php

namespace App\Form\Type;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'FirstName',
                'required' => true,
                'attr' => ['maxlength' => 255, 'class' => "inputText"],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Regex([
                        'pattern' => '/^[a-zA-Z]+$/',
                        'message' => 'Le nom doit contenir uniquement des lettres.',
                    ]),
                    new Assert\Length(['max' => 255]),
                ],
            ])
            ->add('lastname', TextType::class, [
                'label' => 'LastName',
                'required' => true,
                'attr' => ['maxlength' => 255, 'class' => "inputText"],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Regex([
                        'pattern' => '/^[a-zA-Z]+$/',
                        'message' => 'Le nom doit contenir uniquement des lettres.',
                    ]),
                    new Assert\Length(['max' => 255]),
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'required' => false,
                'attr' => ['maxlength' => 255, 'class' => "inputText"],
            ])
            ->add('phone', TelType::class, [
                'label' => 'Phone',
                'required' => false,
                'attr' => ['maxlength' => 10, 'class' => "inputText"],
                'constraints' => [
                    new Assert\Regex([
                        'pattern' => '/^[0-9]+$/',
                        'message' => 'Le nom doit contenir uniquement des lettres.',
                    ]),
                ],
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Message',
                'required' => true,
                'attr' => ['maxlength' => 1000, 'class' => "inputTextarea"],
            ])
            ->add('submit', SubmitType::class,
            ['label' => 'Submit']
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            "data_class" => Contact::class,
            'constraints' => [
                new Assert\Callback([$this, 'validateEmailOrPhone']),
            ],
        ]);
    }

    public function validateEmailOrPhone($data, ExecutionContextInterface $context)
    {
        $email = $data->getEmail();
        $phone = $data->getPhone();

        if (empty($email) && empty($phone)) {
            $context
                ->buildViolation('Either email or phone must be provided.')
                ->atPath('email')
                ->addViolation();
            
            $context
                ->buildViolation('Either email or phone must be provided.')
                ->atPath('phone')
                ->addViolation();
        }
    }
}