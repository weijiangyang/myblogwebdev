<?php
namespace App\Model;

use Twig\Cache\NullCache;

class WelcomeModel
{
    const SITE_TITLE_LABEL = "Titre du site";
    const SITE_TITLE_NAME = "blog_title";

    const SITE_INSTALLED_LABEL = "site installé";
    const SITE_INSTALLED_NAME = "blog installé";
    
    private ?string $siteTitle;
    private ?string $email = null;
    private ?string $password;
    private ?string $fullName;

    /** 
     * @return string|null
    */
    public function getSiteTitle():?string
    {
        return $this->siteTitle;
    }
    /**
     
     * @param string|null $siteTitle
     * @return void
     */
    public function setSiteTitle(?string $siteTitle):void
    {
        $this->siteTitle = $siteTitle;
    }

    /** 
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }
    /**
     
     * @param string|null $siteTitle
     * @return void
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    /** 
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }
    /**
     
     * @param string|null $siteTitle
     * @return void
     */
    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

   /**
    * 
    *
    * @return string|null
    */
    public function getFullName():?string
    {
        return $this->fullName;
    }

    /**
     * 
     *
     * @param string|null $fullName
     * @return void
     */
    public function setFullName(?string $fullName):void
    {
        $this->fullName = $fullName;
    }

   


    
}