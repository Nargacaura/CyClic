<?php

namespace App\Form;

use App\Entity\Localisation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LocalisationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ville', TextType::class, [
                'label' => false,
            ])
            ->add('codePostal', TextType::class, [
                'label' => false,
            ])
            ->add('rue', TextType::class, [
                'label' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Localisation::class,
        ]);
    }
}
