<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class AdminDashboardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('Bannissement', CheckboxType::class, [
            'mapped' => false,
            'constraints' => [
                new IsTrue([
                    'message' => 'Bannissement de lutilisateur',
                ]),
            ],
        ]);
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
       /* $resolver->setDefaults([
            'data_class' => Categorie::class,
        ]);*/
    }
}
