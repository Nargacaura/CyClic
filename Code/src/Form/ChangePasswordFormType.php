<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Constraints\NotCompromisedPassword;

class ChangePasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'attr' => [
                        'autocomplete' => 'new-password',
                        'placeholder' => 'Nouveau mot de passe'
                    ],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Un mot de passe est requis pour continuer.',
                        ]),
                        new Length([
                            'min' => 6,
                            'minMessage' => 'C\'est trop faible! Il doit être d\'au moins {{ limit }} caractères.',
                            // max length allowed by Symfony for security reasons
                            'max' => 4096,
                        ]),
                        new Regex([
                            'pattern' => '/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$ %^&*-]).{6,}$/',
                            'message' => 'Votre mot de passe doit contenir au moins une majuscule, une minuscule, un chiffre et une ponctuation!',
                            'match' => true,
                        ]),
                        new NotCompromisedPassword([
                            'message' => 'Il semblerait que ce mot de passe soit compromis. Essayez un autre.'
                        ])
                    ],
                    'label' => false ,
                ],
                'second_options' => [
                    'attr' => [
                        'autocomplete' => 'new-password',
                        'placeholder' => 'Confirmation du nouveau mot de passe'
                    ],
                    'label' => false,
                ],
                'invalid_message' => 'Vous êtes sûr que ces 2 mots de passe sont similaires? On dirait pas pour nous.',
                // Instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
