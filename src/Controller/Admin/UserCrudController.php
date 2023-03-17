<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        
            yield TextField::new('fullName');
            yield TextField::new('email');
            yield TextField::new('password')
                        ->setFormType(PasswordType::class)
                        ->hideOnForm()
                        ->hideOnIndex();
            yield ChoiceField::new('roles')
                    ->allowMultipleChoices()
                    ->renderAsBadges([
                        'ROLE_ADMIN'=> 'success',
                        'ROLE_AUTHOR'=> 'warning'
                    ])
                    ->setChoices([
                        'Administrateur'=> 'ROLE_ADMIN',
                        'Auteur'=> 'ROLE_AUTHOR'
                    ]);
            
            
           
    
    }
    
}
