<?php

namespace App\Form;


use App\Entity\Recette;
use \App\Repository\IngredientRepository;
use App\Entity\Ingredient;
use App\Form\IngredientType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints as Assert;

class RecetteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'attr' =>[
                    'class' => 'mt-4 form-control'
                ],
                'label' => 'Nom Recette:',
                'label_attr' => [
                    'class' => 'mt-4 form-label'
                ],
                'constraints' => [
                    new Assert\NotBlank()
                ]
            ])
            ->add('duree', IntegerType::class, [
                'attr' =>[
                    'class' => 'mt-4 form-control'
                ],
                'label' => 'Durée: (en minutes)',
                'label_attr' => [
                    'class' => 'mt-4 form-label'
                ],
            ])
            ->add('difficulte', ChoiceType::class, [
                'attr' =>[
                    'class' => 'mt-4 form-control'
                ],
                'label' => 'Difficulté:',
                'label_attr' => [
                    'class' => 'mt-4 form-label'
                ],
                'choices' => [
                    '--' => '--',
                    'Facile' => 'Facile',
                    'Intermédiaire' => 'Intermédiaire',
                    'Difficile' => 'Difficile'
                ]
            ])
            ->add('description', TextareaType::class, [
                'attr' =>[
                    'class' => 'mt-4 form-control'
                ],
                'label' => 'Description:',
                'label_attr' => [
                    'class' => 'mt-4 form-label'
                ],
                'constraints' => [
                    new Assert\NotBlank()
                ]
            ])
            ->add('ingredient', EntityType::class, [
                'class' => Ingredient::class,
                'query_builder'=> function (IngredientRepository $r){
                    return $r->createQueryBuilder('i')
                            ->orderBy('i.nom', 'ASC');

                },
                'choice_label' => 'nom',
                'multiple' => true,
                'expanded' => true,
            ])

            ->add('submit', SubmitType::class, [
                'attr' =>[
                    'class' => 'mt-4 form-control'
                ],
                'label' => 'Créez votre recette 😋'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recette::class,
        ]);
    }
}
