<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;


class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => [
                    'placeholder' => ' ',
                    'autofocus' => true
                ]
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Prénom',
                'attr' => [
                    'placeholder' => ' ',
                    'maxlength' => 50
                ]
            ])
            ->add('nom', TextType::class, [
                'attr' => [
                    'placeholder' => ' ',
                    'maxlength' => 50
                ]
            ])
            ->add('adresse1', TextType::class, [
                'label' => 'Adresse principale',
                'attr' => [
                    'placeholder' => ' ',
                    'maxlength' => 95
                ]
            ])
            ->add('adresse2', TextType::class, [
                'label' => 'Complément d\'adresse',
                'required' => false,
                'attr' => [
                    'placeholder' => ' ',
                    'maxlength' => 95
                ]
            ])
            ->add('code_postal', TextType::class, [
                'attr' => [
                    'placeholder' => ' ',
                ]
            ])
            ->add('ville', TextType::class, [
                'attr' => [
                    'placeholder' => ' ',
                    'maxlength' => 35
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password', 'minlength' => 6],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Le mot de passe doit contenir {{ limit }} caractères minimum',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
                'invalid_message' => 'Les mots de passe ne correspondent pas',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => [
                    'label' => 'Mot de passe',
                    'attr' => ['placeholder' => ' ', 'minlength' => '6']
                ],
                'second_options' => [
                    'label' => 'Confirmer mot de passe',
                    'attr' => ['placeholder' => ' ', 'minlength' => '6']
                ],
            ])
            /*->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
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
            ])*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
