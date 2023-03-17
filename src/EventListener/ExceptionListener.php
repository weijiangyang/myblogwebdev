<?php
namespace App\EventListener;

use App\Service\DatabaseService;
use Doctrine\DBAL\Exception\ConnectionException;
use Doctrine\DBAL\Exception\TableNotFoundException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Routing\RouterInterface;

class ExceptionListener 
{
    private $databaseService;
    private $router;

    public function __construct(
        DatabaseService $databaseService,
        RouterInterface $router)
    {
        $this->databaseService = $databaseService;
        $this->router = $router;
    }

    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();

        if($exception instanceof ConnectionException 
        || $exception instanceof TableNotFoundException ){
            $this->databaseService->createDatabase();
            $event->setResponse(new RedirectResponse($this->router->generate('app_welcome')));
        }

    }
}