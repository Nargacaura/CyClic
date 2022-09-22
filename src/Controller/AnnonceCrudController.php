<?php

/**
 * <h2>Annonce crud controller</h2>
 * <p>Récupere les informations pour les importées dans le DashboardController.</p>
 * @author Antonin Mougenot
 */

namespace App\Controller;

use App\Entity\Annonce;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AnnonceCrudController extends AbstractCrudController
{
    /**
     * <h3>Récupere toute les champs de l'entité annonce</h3>
     * @return Annonce::class récupére tout ce qu'il y a dans l'entité annonce
     */
    public static function getEntityFqcn(): string
    {
        return Annonce::class;
    }


    /**
     * <h3>Récupere certain champs de l'entité annonce</h3>
     * <ul>
     * <li>@param $pageName met en page les différente menu </li>
     * </ul>
     * @return[TextField::new('titre'),DateField::new('date_publication'),TextEditorField::new('contenu'),] récupere certain champ de l'entité annonce 
     */
    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('auteur'),
            TextField::new('titre'),
            DateField::new('date_publication'),
            TextEditorField::new('contenu'),
        ];
    }
}
