<?php

/**
 * <h2>Etat crud controller</h2>
 * <p>Récupere les informations pour les importées dans le DashboardController.</p>
 *
 */

namespace App\Controller\Admin;

use App\Entity\Etat;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class EtatCrudController extends AbstractCrudController
{
    /**
     * <h3>Récupere toute les champs de l'entité Etat</h3>
     * @return Etat::class récupére tout ce qu'il y a dans l'entité Etat
     */
    public static function getEntityFqcn(): string
    {
        return Etat::class;
    }

    /**
     * <h3>Récupere certain champs de l'entité Etat</h3>
     * <ul>
     * <li>@param $pageName met en page les différente menu </li>
     * </ul>
     * @return [TextField::new('nom'),]; récupere certain champ de l'entité Etat 
     */
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nom'),
        ];
    }
}
