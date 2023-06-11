<?php

namespace App\Form;

use App\Entity\Recette;
use App\Entity\Allergie;
use App\Entity\Regime;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Validator\Constraints\IsTrue;

class RecetteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('imageFile', FileType::class)
            ->add('titre', TextType::class, [
                'label' => 'Nom de la recette',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ ne peut être vide'
                    ])
                    ],
                ])
            ->add('description', TextType::class, [
                'label' => 'Description',
                'constraints' => [
                     new NotBlank([
                        'message' => 'Ce champ ne peut être vide'
                    ])
                    ],
                    ])
            ->add('tempspreparation', TimeType::class, [
                'label' => 'Temps de préparation ',
                    'widget' => 'single_text', 
            ])
            ->add('tempsrepos', TimeType::class, [
                'label' => 'Temps de repos ',
                    'widget' => 'single_text', 
            ])
            ->add('tempscuisson', TimeType::class, [
                'label' => 'Temps de cuisson ',
                    'widget' => 'single_text', 
            ])
            ->add('ingredients', TextType::class, [
                'label' => 'Ingrédients',
                'constraints' => [
                     new NotBlank([
                        'message' => 'Ce champ ne peut être vide'
                    ])
                    ],
                    ])
            ->add('etapes', TextType::class, [
                'label' => 'Etapes',
                'constraints' => [
                     new NotBlank([
                        'message' => 'Ce champ ne peut être vide'
                    ])
                    ],
                    ])
            // ->add('typesregimes')
            // ->add('allergenes')
            ->add('allergies', EntityType::class, [
                'class' => Allergie::class,
                'multiple' => true,
                'expanded' => false,
            ])
            ->add('regimes', EntityType::class, [
                'class' => Regime::class,
                'multiple' => true,
                'expanded' => false,
            ])
            ->add('access', CheckboxType::class, [
                'label' => "Accessible aux patients",
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
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
