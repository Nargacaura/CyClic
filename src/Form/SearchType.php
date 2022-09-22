<?php

namespace App\Form;

use App\Entity\Categorie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'categorie',
                EntityType::class,
                [
                    'class' => Categorie::class,
                    'choice_label' => 'nom',
                    'placeholder' => "Catégorie"
                ]
            )
            ->add('localisation', TextType::class, ['attr' => [
                'placeholder' => 'Localisation',
            ]])
            ->add('titre', TextType::class, ['attr' => [
                'placeholder' => 'Nom Annonce',
            ]])
            ->add('save', SubmitType::class, ['label' => 'Rechercher une annonce']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'method' => 'GET'
            // Configure your form options here
        ]);
    }
}
