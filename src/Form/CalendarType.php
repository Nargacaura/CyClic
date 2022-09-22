<?php

namespace App\Form;

use App\Entity\CalendarData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CalendarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id', HiddenType::class,[
                'mapped' => false,   
                ])
            ->add('titre', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'titre',
                    'class' => 'formContent',
                ]
            ])
            ->add('description', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => "indiquer plus d'information...",
                    'class' => 'formContent',
                ]
            ])
            ->add('debut', DateTimeType::class, [
                'years' => range(date("Y"), (((int)date("Y")) + 1)),
                'date_label' => 'Starts On',
                'time_label' => 'Starts On',
            ])
            ->add('fin', DateTimeType::class, [
                'years' => range(date("Y"), (((int)date("Y")) + 1)),
                'date_label' => 'End On',
                'time_label' => 'End On',
            ])
            ->add('add', SubmitType::class, ['label' => 'Ajouter au calendrier'])
            ->add('delete', SubmitType::class, ['label' => 'Supprimer'])
            ->add('update', SubmitType::class, ['label' => 'Modifier'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CalendarData::class,
        ]);
    }
}
