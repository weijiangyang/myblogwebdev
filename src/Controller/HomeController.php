<?php

namespace App\Controller;

use DateTime;
use WelcomeModel;
use App\Entity\User;
use App\Entity\Option;
use App\Form\WelcomeType;
use App\Service\OptionService;
use App\Service\ArticleService;
use App\Service\DatabaseService;
use function PHPSTORM_META\type;
use App\Repository\OptionRepository;
use Doctrine\DBAL\Types\BooleanType;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Config\TwigExtra\StringConfig;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_welcome')]
    public function welcome(
      Request $request,
      EntityManagerInterface $em,
      UserPasswordHasherInterface $hasher,
      OptionRepository $optionRepository,
      DatabaseService $databaseService
    ): Response 
    {

      if ($optionRepository->getValue(\App\Model\WelcomeModel::SITE_INSTALLED_NAME)) {
        return $this->redirectToRoute('app_home');
      }

      $welcomeForm = $this->createForm(WelcomeType::class, new \App\Model\WelcomeModel);
      $welcomeForm->handleRequest($request);
      //  dd($welcomeForm->getData());

      if ($welcomeForm->isSubmitted() && $welcomeForm->isValid()) {

        /**
         * @var \App\Model\WelcomeModel
         */
        $data = $welcomeForm->getData();
        $siteTitle = new Option(\App\Model\WelcomeModel::SITE_TITLE_LABEL, 
        \App\Model\WelcomeModel::SITE_TITLE_NAME, 
        $data->getSiteTitle(), 
        TextType::class);
        $siteInstalled = new Option(\App\Model\WelcomeModel::SITE_INSTALLED_LABEL, \App\Model\WelcomeModel::SITE_INSTALLED_NAME, true, null);


        $user = new User();
        $user->setEmail($data->getEmail());
        $user->setRoles(["ROLE_ADMIN"]);
        $user->setFullName($data->getFullName());
        $user->setPassword($hasher->hashPassword($user, $data->getPassword()));

        $em->persist($user);
        $em->persist($siteTitle);
        $em->persist($siteInstalled);


        // $databaseService->createDatabase();




        $em->flush();

        return $this->redirectToRoute("app_home");
      }
      return $this->render('home/welcome.html.twig', [
        'welcomeForm' => $welcomeForm->createView()
      ]);
    }
    
    #[Route('/home', name: 'app_home')]
    public function index(ArticleService $articleService,ArticleRepository $articleRepository,CategoryRepository $categoryRepository): Response
    {
        $articles = $articleService->getPaginatedArticles(3,null);
        $str = [];
        for($i = 0; $i <12; $i++){
          $str[] = date('Y-m',strtotime('-' . $i . 'month'));
        

        }
        
        return $this->render('home/index.html.twig', [
            'articles' => $articles,
            'categories'=> $categoryRepository->findAll(),
            'months' => $str
            
        ]);
    }

  #[Route('/archive/{month}', name: 'app_archive')]
  public function archive(string $month,ArticleService $articleService, ArticleRepository $articleRepository, CategoryRepository $categoryRepository): Response
  {
    $articles = $articleService->getArchiveArticles($month);

    return $this->render('home/archive.html.twig', [
      'articles' => $articles,
      'month' => $month
   
    ]);
  }
   
}
