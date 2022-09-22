<?php

/**
 * <h2>Signalement crud controller</h2>
 * <p>Récupere les informations pour les importées dans le DashboardController.</p>
 * @author Antonin Mougenot
 *
 */

namespace App\Controller\Admin;

use App\Entity\Signalement;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class SignalementCrudController extends AbstractCrudController
{
    /**
     * <h3>Récupere toute les champs de l'entité Signalement</h3>
     * @return Signalement::class récupére tout ce qu'il y a dans l'entité Signalement
     */
    public static function getEntityFqcn(): string
    {
        return Signalement::class;
    }

    /**
     * <h3>Récupere certain champs de l'entité Signalement</h3>
     * <ul>
     * <li>@param $pageName met en page les différente menu </li>
     * </ul>
     * @return [IdField::new('id'),AssociationField::new('auteur'),AssociationField::new('annonce'),TextField::new('objet'),TextEditorField::new('description'),]; récupere certain champ de l'entité annonce 
     */
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            AssociationField::new('auteur'),
            AssociationField::new('annonce'),
            TextField::new('objet'),
            TextEditorField::new('description'),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->remove(Crud::PAGE_INDEX, Action::EDIT)
            ->remove(Crud::PAGE_DETAIL, Action::EDIT);
    }
}
