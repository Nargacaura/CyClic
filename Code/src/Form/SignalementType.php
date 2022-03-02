<?php

namespace App\Form;

use App\Entity\Signalement;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\TextEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
/**
 * <h2>Formulaire du signalement</h2>
 * <p>Créer et gere le formulaire du signalement.</p>
 * @author Antonin Mougenot
 *
 */

class SignalementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('objet', TextType::class, [
                'attr' => [
                    'class' => 'form-control objet',
                    'name' => 'objet',
                    'placeholder' => 'Ici le sujet du signalement',
                    'style' => 'margin: auto; width: 90%;'
                ]
            ])
            ->add('description', TextEditorType::class, [
                'attr' => [
                    'class' => 'form-control objet',
                    'name' => 'objet',
                    'placeholder' => 'Ici une breve description du probleme (max 404 caractere)',
                    'style' => 'height: 200px; resize: none; margin: auto; width: 90%;',
                    'maxlengh' => '404'
                ]
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
            'data_class' => Signalement::class,
        ]);
    }
}
