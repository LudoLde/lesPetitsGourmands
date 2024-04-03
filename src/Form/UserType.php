<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ReapetedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints as Assert;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prenom', TextType::class, [
                'attr' =>[
                    'class' => 'mt-4 form-control'
                ],
                'label' => 'Prénom:',
                'label_attr' => [
                    'class' => 'mt-4 form-label'
                ],
                'constraints' => [
                    new Assert\NotBlank()
                ]
            ])
            ->add('nom', TextType::class, [
                'attr' =>[
                    'class' => 'mt-4 form-control'
                ],
                'label' => 'Nom:',
                'label_attr' => [
                    'class' => 'mt-4 form-label'
                ],
                'constraints' => [
                    new Assert\NotBlank()
                ]
            ])
            ->add('email', EmailType::class, [
                'attr' =>[
                    'class' => 'mt-4 form-control'
                ],
                'label' => 'Adresse Email:',
                'label_attr' => [
                    'class' => 'mt-4 form-label'
                ],
                'constraints' => [
                    new Assert\NotBlank()
                ]
            ])
            ->add('password', ReapetedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe ne correspondent pas.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['label' => 'Mot de passe.'],
                'second_options' => ['label' => 'Confirmez le mot de passe.'],
                'constraints' => [
                    new Assert\NotBlank()
                ]
            ])

            ->add('submit', SubmitType::class, [
                'attr' =>[
                    'class' => 'mt-4 form-control'
                ],
                'label' => 'Créez un compte !'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
