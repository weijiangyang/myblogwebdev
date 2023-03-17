<?php
namespace App\Twig;

use App\Entity\Menu;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\Routing\RouterInterface;
use Twig\TwigFilter;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public $router;
    public $adminUrlGenerator;
    const ADMIN_NAMESPACE = "App\Controller\Admin";

    public function __construct( RouterInterface $router, AdminUrlGenerator $adminUrlGenerator)
    {
        $this->router = $router;
        $this->adminUrlGenerator = $adminUrlGenerator;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('ea_index',[$this,'getAdminUrl'])
        ];
    }

    public function getAdminUrl(string $controller,?string $action = null):string
    {
        $adminUrlGenerator =  $this->adminUrlGenerator
                    ->setController(self::ADMIN_NAMESPACE . '\\' . $controller);
        if($action){
            $adminUrlGenerator->setAction($action);
        }
                
        return $adminUrlGenerator->generateUrl();         

    }

    public function getFilters()
    {
        return [
            new TwigFilter('menuLink',[$this,'menuLink'])
        ];
    }

    public function menulink(Menu $menu){
        $url = $menu->getLink()?:"#";
        if($url!=="#"){
            return $url;
        }

    $article = $menu->getArticle();
    $page = $menu->getPage();
    $category = $menu->getCategory();

    if($article){
        $name = 'article_show';
        $slug = $article->getSlug();
    }
    if ($category) {
        $name = 'category_show';
        $slug = $category->getSlug();
    }
    if ($page) {
        $name = 'page_show';
        $slug = $page->getSlug();
    }

    return $this->router->generate($name,[
        'slug' => $slug
    ]);

    }
}