<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Article;
use App\Repository\ArticleRepository;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ArticleCrudController extends AbstractCrudController
{
    private $articleRepository;
    private $token;
    public function __construct(ArticleRepository $articleRepository, TokenStorageInterface $token)
    {
        $this->articleRepository = $articleRepository;
        $this->token = $token;
    }
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }
   

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        /**
        * @var User
        */
         $user = $this->token->getToken()->getUser();
        if(in_array('ROLE_AUTHOR',$user->getRoles())){
            
            return $this->articleRepository->getIndexQueryBuilder($user->getId());
                
        }else{
            return $this->articleRepository->createQueryBuilder('a');
        }
        
      
    }
  

    
    public function configureFields(string $pageName): iterable
    {
       
        yield TextField::new('title');
        yield SlugField::new('slug')->setTargetFieldName('title');
        yield TextEditorField::new('content');
        yield TextField::new('featuredText');
        yield AssociationField::new('featuredImage');
        yield AssociationField::new('categories');
        yield AssociationField::new('author')
                ->hideOnForm();   
        yield DateTimeField::new('createdAt')->hideOnForm();
        yield DateTimeField::new('updatedAt')->hideOnForm();
            
           
    
    }
   
}
