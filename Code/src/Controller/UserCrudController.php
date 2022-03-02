<?php

namespace App\Controller;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

/**
 * <h2>Signalement crud controller</h2>
 * <p>Récupere les informations pour les importées dans le DashboardController.</p>
 * @author Antonin Mougenot
 *
 */
class UserCrudController extends AbstractCrudController
{
    /**
     * <h3>Récupere toute les champs de l'entité user</h3>
     * @return User::class récupére tout ce qu'il y a dans l'entité user
     */
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    /**
     * <h3>Récupere certain champs de l'entité user</h3>
     * <ul>
     * <li>@param $pageName met en page les différente menu </li>
     * </ul>
     * @return[IdField::new('id'),TextField::new('nom'),TextField::new('prenom'),TextField::new('pseudo'),DateField::new('date_naissance'),BooleanField::new('ban'),]; récupere certain champ de l'entité annonce 
     */
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('nom'),
            TextField::new('prenom'),
            TextField::new('pseudo'),
            DateField::new('date_naissance'),
            BooleanField::new('ban'),
        ];
    }
    
}
