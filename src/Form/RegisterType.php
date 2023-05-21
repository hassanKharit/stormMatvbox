<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Votre prénom',
                'constraints' => [
                    new Length([
                        'min' => 2,
                        'minMessage' => 'Votre prénom doit comporter au moins {{ limit }} caractères',
                        'max' => 30,
                    ]),
                ],
                'attr' => [
                    'placeholder' => 'Merci de saisir votre prénom',
                ],
            ])

            ->add('lastname',type: TextType::class, options: [
                'label' => 'votre nom',
                'constraints' => [
                    new Length([
                        'min' => 2,
                        'minMessage' => 'Votre nom doit comporter au moins {{ limit }} caractères',
                        'max' => 30,
                    ]),
                    new Regex([
                        'pattern' => '/^[A-Za-z\-\'éèàêëç\s]+$/',
                        'message' => 'Votre prénom ne peut contenir que des lettres, des tirets, des apostrophes et des espaces',
                    ]),
                ],
                'attr' => [
                    'placeholder' => 'Merci de saisir votre nom'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Votre email',
                'attr' => [
                    'placeholder' => 'Merci de saisir votre adresse email',
                ],
                'constraints' => [
                    new Email([
                        'message' => 'L\'adresse email "{{ value }}" n\'est pas valide.',
                    ]),
                ],
            ])


//            ->add('password', RepeatedType::class, [
//                'type' => PasswordType::class,
//                'invalid_message' => 'Le mot de passe et la confirmation doivent être identiques.',
//                'label' => 'Votre mot de passe',
//                'required' => true,
//                'first_options' => ['label' =>'Mot de passe'],
//                'second_options' => ['label' =>'Confirmez votre mot de passe'],
//                'constraints' => [
//                    new NotBlank([
//                        'message' => 'Veuillez saisir un mot de passe.',
//                    ]),
//                    new Length([
//                        'min' => 8,
//                        'minMessage' => 'Le mot de passe doit contenir au moins {{ limit }} caractères.',
//                        'max' => 255,
//                        'maxMessage' => 'Le mot de passe ne peut pas dépasser {{ limit }} caractères.',
//                    ]),
//                    new Regex([
//                        'pattern' => '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/',
//                        'message' => 'Le mot de passe doit contenir au moins une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial.',
//                    ]),
//                ],
//            ])

            ->add('password', RepeatedType::class, array(
                'type' => PasswordType::class,
                'invalid_message' => 'le mot de passe et la confirmation doivent être identique.',
                'label' => 'Votre mot de passe',
                'required' => true,
                'first_options' => ['label' =>'Mot de passe'],
                'second_options' => ['label' =>'Confirmez votre mot de passe'],


            ))

            ->add('submit', submitType::class, options: [
                'label' => "s'inscrire"
            ] )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
