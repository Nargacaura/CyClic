<?php

namespace App\Form;

use App\Entity\Etat;
use App\Entity\Annonce;
use App\Form\PhotoType;
use App\Entity\Categorie;
use App\Entity\Localisation;
use Symfony\Component\Form\AbstractType;
use App\Repository\LocalisationRepository;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class AnnonceType extends AbstractType
{

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'titre',
                    'class' => 'formContent',
                ]
            ])
            ->add('contenu', TextareaType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'description',
                    'class' => 'formContent',
                ]
            ])
            ->add('localisation', EntityType::class, [
                'placeholder' => 'Localisation',
                'label' => false,
                'attr' => [
                    'class' => 'bouton bouton-localisation',
                ],
                'class' => Localisation::class,
                'query_builder' => function (LocalisationRepository $lr) {
                    return $lr->createQueryBuilder('l')
                        ->where('l.userLocalisation = :u')
                        ->orderBy('l.id', 'ASC')
                        ->setParameter('u', $this->security->getUser());
                },
            ])
            ->add('categorie', EntityType::class, [
                'attr' => [
                    'class' => 'bouton',
                ],
                'placeholder' => 'Catégorie',
                'label' => false,
                'class' => Categorie::class,
                'choice_label' => 'nom',
            ])
            ->add('etat', EntityType::class, [
                'attr' => [
                    'class' => 'bouton',
                ],
                'placeholder' => 'Etat',
                'label' => false,
                'class' => Etat::class,
                'choice_label' => 'nom',
            ])
            ->add('photos', CollectionType::class, [
                'label' => false,
                'entry_type' => PhotoType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ])
            ->add('valider', SubmitType::class, [
                'attr' => [
                    'class' => 'auth_btn',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Annonce::class,
        ]);
    }
}
