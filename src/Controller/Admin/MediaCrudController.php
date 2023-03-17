<?php

namespace App\Controller\Admin;

use App\Entity\Media;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class MediaCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Media::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
       $mediaDirectory = $this->getParameter('medias_directory');
       $uploadDirectory = $this->getParameter('uploads_directory');
        
        yield  TextField::new('name');
       $imageField = ImageField::new('fileName',"Medias")
                    ->setBasePath($uploadDirectory)
                    ->setUploadDir($mediaDirectory)
                    ->setUploadedFileNamePattern('[slug]-[uuid].[extension]');
        if(Crud::PAGE_EDIT === $pageName){
            $imageField->setRequired(false);
        } 

        yield $imageField;

        yield TextField::new('altText','Text alternatif');
    
    }
    
}
