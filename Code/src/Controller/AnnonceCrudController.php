<?php

namespace App\Controller;



use App\Entity\Annonce;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;

class AnnonceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Annonce::class;
    }
    

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('titre'),
            DateField::new('date_publication'),
            TextEditorField::new('contenu'),
        ];
    }
    
}
