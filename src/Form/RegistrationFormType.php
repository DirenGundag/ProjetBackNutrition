<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Allergie;
use App\Entity\Regime;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

        ->add('nom', TextType::class, [
            'label' => 'Nom',
            'constraints' => [
                new NotBlank([
                    'message' => 'Ce champ ne peut être vide'
                ])
                ],
                'attr' => [
                    'placeholder' => 'Entrez votre nom'
                ]
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Prénom',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ ne peut être vide'
                    ])
                    ],
                    'attr' => [
                        'placeholder' => 'Entrez votre prénom'
                    ]
                ])
            ->add('numTel', TextType::class, [
                'label' => 'Numéro de téléphone',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ ne peut être vide'
                    ])
                ],
                'attr' => [
                    'placeholder' => 'Entrez votre numéro de téléphone'
                ]
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'placeholder' => 'Entrez votre adresse e-mail'
                ]
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'label' => "Accepter les conditions d'utilisation",
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password','placeholder' => 'Entrez votre mot de passe'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
