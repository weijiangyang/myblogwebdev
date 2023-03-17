<?php

namespace App\Service;

use App\Repository\OptionRepository;

class OptionService
{
    public $optionRepository;

    public function __construct(OptionRepository $optionRepository)
    {
        $this->optionRepository = $optionRepository;
    }

    /** 
     * @return Option[]
    */
    public function findAll():array
    {
        return $this->optionRepository->findAllForTwig();
    }

    
   
}
