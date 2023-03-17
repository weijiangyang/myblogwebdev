<?php

namespace App\Service;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Bundle\FrameworkBundle\Console\Application;

class DatabaseService
{
    private $kernel;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    public function createDatabase():bool
    {
        $application = new Application($this->kernel);
        $application->setAutoExit(false);

        $input = new ArrayInput([
            'command' => 'd:d:c'
        ]);

        $this->run($application, $input);

        $input = new ArrayInput([
            'command'=> 'd:s:c'
        ]);
        
        $this->run($application,$input);

        $input = new ArrayInput([
            'command'=> 'd:s:u',
            '--force'=> true
        ]);
        $this->run($application, $input);

       

        $input = new ArrayInput([
            'command' => 'd:f:l --env=dev',
            '--append' => true
        ]);
        $this->run($application, $input);

        return Command::SUCCESS;
    }

    private function run(Application $application, ArrayInput $input)
    {
        try {
            $result = $application->run($input);
        } catch (\Throwable $th) {
            $result = false;
        }

        return $result;
    }
}