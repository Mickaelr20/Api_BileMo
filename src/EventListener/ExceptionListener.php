<?php

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
        $exception = $event->getThrowable();

        $event->setResponse(
            new JsonResponse(
                [
                    'code' => $exception->getStatusCode(),
                    'message' => match ($exception::class) {
                        NotFoundHttpException::class => 'Cette resource n\'existe pas',
                        default => $exception->getMessage()
                    }
                ],
                $exception->getStatusCode(),
            )
        );
    }
}
