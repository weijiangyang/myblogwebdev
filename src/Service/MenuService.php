<?php
namespace App\Service;

use App\Repository\MenuRepository;

class MenuService
{
    public $menuRepository;

    public function __construct(MenuRepository $menuRepository)
    {
        $this->menuRepository = $menuRepository;
    }

    /**
     * 
     *
     * @return Menu[]
     */
    public function findAll(){
        return $this->menuRepository->findAllForTwig();
    }

}