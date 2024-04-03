<?php

namespace App\Form;

use App\Entity\Ingredient;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints as Assert;

class IngredientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'attr' =>[
                    'class' => 'mt-4 form-control'
                ],
                'label' => 'Nom ingredient',
                'label_attr' => [
                    'class' => 'mt-4 form-label'
                ],
                'constraints' => [
                    new Assert\NotBlank()
                ]
            ])
            ->add('type', ChoiceType::class, [
                'attr' =>[
                    'class' => 'mt-4 form-control'
                ],
                'label' => 'Type',
                'label_attr' => [
                    'class' => 'mt-4 form-label'
                ],
                'choices' => [
                    '--' => '--',
                    'Légumes' => 'Légumes',
                    'Fruits' => 'Fruits',
                    'Épices' => 'Épices',
                ]
            ])
            ->add('submit', SubmitType::class, [
                'attr' =>[
                    'class' => 'mt-4 form-control'
                ],
                'label' => 'Créez votre ingredient'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ingredient::class,
        ]);
    }
}
