<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * <h2>Formulaire d'édition de profil</h2>
 * <p>Créer le formulaire d'édition afin de permettre à l'utilisateur de modifier
 * son profil.</p>
 * @author Antonin Mougenot
 */
class ProfilEditType extends AbstractType
{
    /**
     * <h3>Création du formulaire d'édition de profil</h3>
     * <ul>
     * <li>@param $builder parametre de symfony pour créer le formulaire</li>
     * <li>@param $options est un tableau </li>
     * </ul>
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Vous devez avoir un e-mail pour continuer.'
                    ]),
                ],
                'attr' => [
                    'class' => 'form-control email'
                ]
            ])
            ->add('pseudo', TextType::class, [
                'attr' => [
                    'class' => 'form-control pseudo',
                    'name' => 'pseudo'
                ]
            ])
            ->add('nom', TextType::class, [
                'attr' => [
                    'class' => 'form-control nom',
                    'name' => 'nom'
                ],
            ])
            ->add('prenom', TextType::class, [
                'attr' => [
                    'class' => 'form-control prenom',
                    'name' => 'prenom'
                ],     
            ])
            ->add('avatar', TextType::class, [
                'attr' => [
                    'class' => 'form-control avatar'
                ]
            ])

            ->add('valider', SubmitType::class, [
                'attr' => [
                    'class' => 'auth_btn',
                ],
            ]);
    }
    /**
     * <h3>Affichage du profil</h3>
     * <ul>
     * <li>@param $resolver Valide les options et merges les valeurs par défaut</li>
     * </ul>
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
