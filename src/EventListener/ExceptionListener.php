<?php
// src/EventListener/ExceptionListener.php
namespace App\EventListener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ExceptionListener
{
    public function __invoke(ExceptionEvent $event): void
    {
        // You get the exception object from the received event
        // $exception = $event->getThrowable();

        // $event->setResponse(
        //     new JsonResponse(
        //         [
        //             'code' => $event->getResponse()->getStatusCode(),
        //             'message' => match($exception::class){
        //                 NotFoundHttpException::class => 'Cette resource n\'existe pas'
        //             }
        //         ],
        //         $event->getResponse()->getStatusCode(),
        //     )
        // );

        // if ($exception instanceof NotFoundHttpException) {

        // }
    }
}
