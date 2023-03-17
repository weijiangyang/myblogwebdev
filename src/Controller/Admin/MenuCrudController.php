<?php

namespace App\Controller\Admin;

use App\Entity\Menu;
use App\Repository\MenuRepository;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Symfony\Component\HttpFoundation\RequestStack;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class MenuCrudController extends AbstractCrudController
{
    const MENU_PAGES = 0;
    const MENU_ARTICLES = 1;
    const MENU_LINKS = 2;
    const MENU_CATEGORIES = 3; 

    public $requestStack;
    public $menuRepository;

    public function __construct(RequestStack $requestStack,MenuRepository $menuRepository)
    {
        $this->requestStack = $requestStack;
        $this->menuRepository = $menuRepository;
    }

    public static function getEntityFqcn(): string
    {
        return Menu::class;
    }
    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $subMenuIndex = $this->getSubMenuIndex();
        $field = $this->getFieldNameFromSubmenuIndex($subMenuIndex);
        return $this->menuRepository->getIndexQueryBuilder($field);
        
    }

    public function configureCrud(Crud $crud): Crud
    {
        $subMenuIndex = $this->getSubMenuIndex();
        
        $entityLabelInSingular = 'un menu';
        $entityLabelInPlural = match($subMenuIndex){
            self::MENU_ARTICLES => "Articles",
           
            self::MENU_LINKS => 'Liens personnalisés',
            self::MENU_CATEGORIES => 'Catégories',
            default  => 'Pages'
        };
        
       return $crud
        ->setEntityLabelInSingular($entityLabelInSingular)
        ->setEntityLabelInPlural($entityLabelInPlural);
        
    }

    private function getSubMenuIndex(){
        return $this->requestStack->getMainRequest()->query->getInt('submenuIndex');
    }

    private function getFieldFromSubmenuIndex(Int $subMenuIndex){
        $fieldName =
        match ($subMenuIndex) {
            self::MENU_ARTICLES => "article",
          
            self::MENU_LINKS => 'link',
            self::MENU_CATEGORIES => 'category',
            default => 'page'
           
        };

        return $fieldName==='link'?TextField::new($fieldName,'Lien'):AssociationField::new($fieldName);
        }
    private function getFieldNameFromSubmenuIndex(Int $subMenuIndex){
        return
        $fieldName =
        match ($subMenuIndex) {
            self::MENU_ARTICLES => "article",
           
            self::MENU_LINKS => 'link',
            self::MENU_CATEGORIES => 'category',
            default => 'page'
        };
    }
    
    public function configureFields(string $pageName): iterable
    {
           $subMenuIndex = $this->getSubMenuIndex();
           yield TextField::new('name','Titre de la navigation');
           yield NumberField::new('menuOrder','Order');
           yield $this->getFieldFromSubmenuIndex($subMenuIndex)
                    ->setRequired(true);
           yield BooleanField::new('isVisible','visible');
           yield AssociationField::new('submenus','Sous-éléments');
           
    
    }
    
}
