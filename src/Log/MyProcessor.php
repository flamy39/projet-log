<?php

namespace App\Log;

// Ajouter dans un log l'adresse ip de la machine qui a activé la route
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Security;

class MyProcessor {

    private RequestStack $requestStack;
    private Security $security;

    public function __construct(RequestStack $requestStack,
                                Security $security) {
        $this->requestStack = $requestStack;
        $this->security = $security;
    }

    // __invoke est appelée automatiquement
    public function __invoke(array $record)
    {
        // Ajouter dans le record l'adresse IP du client
        // Utiliser dans le record la clé "extra"
        $request = $this->requestStack->getCurrentRequest();
        $ip = $request->getClientIp();
        $record["extra"]["ip"] = $ip;
        $record["extra"]["user"] = $this->security->getUser();

        return $record;
    }
}
