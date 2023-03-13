<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ExceptionListener
{
	public function __invoke(ExceptionEvent $event): void
	{
		$exception = $event->getThrowable();

		if (!$exception instanceof HttpException) {
			return;
		}

		$event->setResponse(
			new JsonResponse(
				[
					'code' => $exception->getStatusCode(),
					'message' => match ($exception::class) {
						NotFoundHttpException::class => 'Cette resource n\'existe pas',
						default => $exception->getMessage()
					},
				],
				$exception->getStatusCode(),
			)
		);
	}
}
