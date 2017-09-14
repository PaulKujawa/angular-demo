<?php

namespace AppBundle\EventListener;

use FOS\RestBundle\FOSRestBundle;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\EventListener\ExceptionListener;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

/**
 * @see https://github.com/FriendsOfSymfony/FOSRestBundle/issues/1538
 */
class AccessDeniedListener extends ExceptionListener implements EventSubscriberInterface
{
    /**
     * @var string[]
     */
    private $formats;

    /**
     * @var bool
     */
    private $challenge;

    public function __construct(array $formats, bool $challenge, $controller, LoggerInterface $logger = null)
    {
        $this->formats = $formats;
        $this->challenge = $challenge;
        parent::__construct($controller, $logger);
    }

    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        static $handling;

        if (true === $handling) {
            return false;
        }

        $request = $event->getRequest();

        if (!$request->attributes->get(FOSRestBundle::ZONE_ATTRIBUTE, true)) {
            return false;
        }

        if (empty($this->formats[$request->getRequestFormat()]) && empty($this->formats[$request->getContentType()])) {
            return false;
        }

        $handling = true;

        $exception = $event->getException();

        if ($exception instanceof AccessDeniedException || $exception instanceof AccessDeniedHttpException) {
            $exception = new AccessDeniedHttpException('You do not have the necessary permissions', $exception);
            $event->setException($exception);
            parent::onKernelException($event);
        } elseif ($exception instanceof AuthenticationException) {
            if ($this->challenge) {
                $exception = new UnauthorizedHttpException($this->challenge, 'You are not authenticated', $exception);
            } else {
                $exception = new HttpException(401, 'You are not authenticated', $exception);
            }
            $event->setException($exception);
            parent::onKernelException($event);
        }

        $handling = false;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => ['onKernelException', 10],
        ];
    }
}
