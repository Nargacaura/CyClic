<?php
/**
 * <h2>Catégorie crud controller</h2>
 * <p>Récupere les informations pour les importées dans le DashboardController.</p>
 *
 */

namespace App\Controller\Admin;

use App\Entity\Categorie;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CategorieCrudController extends AbstractCrudController
{
    /**
     * <h3>Récupere toute les champs de l'entité Catégorie</h3>
     * @return Categorie::class récupére tout ce qu'il y a dans l'entité Catégorie
     */
    public static function getEntityFqcn(): string
    {
        return Categorie::class;
    }

    /**
     * <h3>Récupere certain champs de l'entité Catégorie</h3>
     * <ul>
     * <li>@param $pageName met en page les différente menu </li>
     * </ul>
     * @return [TextField::new('nom'),]; récupere certain champ de l'entité annonce 
     */
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nom'),
        ];
    }
    
}
