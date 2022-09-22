<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotCompromisedPassword;
use Symfony\Component\Validator\Constraints\Regex;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Vous devez bien avoir un nom, non?'
                    ])
                ]
            ])
            ->add('prenom', TextType::class, [
                'label' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Il nous faudrait votre prénom.'
                    ])
                ]
            ])
            ->add('date_naissance', DateType::class, [
                'format' => 'dd/MM/yyyy',
                'years' => range(date('Y') - 13, 1900),
                'label' => false
            ])
            ->add('pseudo', TextType::class, [
                'label' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez inscrire votre pseudo.'
                    ])
                ]
            ])
            ->add('email', TextType::class, [
                'label' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Vous devez avoir un e-mail pour continuer.'
                    ])
                ]
            ])
            ->add('locUser', CollectionType::class, [
                'entry_type' => LocalisationType::class,
                'label' => 'cliquez sur le bouton ci-dessous pour vous localiser',
                'allow_add' => true
            ])
            ->add('autoCompleteLocalisation', TextType::class, [
                'mapped' => false,
                'label' => false,
                'required' => true
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'label' => false,
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Impossible de se connecter sans mot de passe.',
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
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Veuillez agréer aux conditions pour pouvoir continuer.',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
