<?php

namespace App\EntityListener;

use App\Entity\Article;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


class ArticleListener
{
    private $token;
    private $userRepository;
    public function __construct(TokenStorageInterface $token,UserRepository $userRepository){
        $this->token = $token;
        $this->userRepository = $userRepository;
    }

   
    public function prePersist(Article $article)
    {

        $article->setAuthor($this->token->getToken()->getUser());
    }

    
}
