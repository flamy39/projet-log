<?php

namespace App\Log;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationFailureEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class AuthenticationSubscriber {
    private LoggerInterface $logger;
    private RequestStack $requestStack;

    /**
     * @param LoggerInterface $logger
     * @param RequestStack $requestStack
     */
    public function __construct(LoggerInterface $databaseLogger, RequestStack $requestStack)
    {
        $this->logger = $databaseLogger;
        $this->requestStack = $requestStack;
    }

    public function onAuthenticationSuccess(AuthenticationSuccessEvent $event) {
        $this->logger->info("Connexion succès");
    }

    public function onAuthenticationFailure(AuthenticationFailureEvent $event) {
        $content = json_decode($this->requestStack->getCurrentRequest()->getContent(),true);
        $this->logger->warning("Tentative de connexion", ["username" => $content["username"]]);
    }

}