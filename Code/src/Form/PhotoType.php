<?php

namespace App\Form;

use App\Entity\Photo;
use App\Entity\Annonce;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PhotoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('path', TextType::class)
            // ->add('annonce')
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'bouton'
                ]
            ]);
        // ->add('annonce', EntityType::class, [
        //     'class' => Annonce::class
        // ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Photo::class,
        ]);
    }
}
