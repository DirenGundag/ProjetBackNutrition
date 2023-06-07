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

class RecetteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('imageFile', FileType::class)
            ->add('titre')
            ->add('description')
            ->add('tempspreparation')
            ->add('tempsrepos')
            ->add('tempscuisson')
            ->add('ingredients')
            ->add('etapes')
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
            ->add('access')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recette::class,
        ]);
    }
}
