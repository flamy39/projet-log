<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    private LoggerInterface $logger;

    // $logger fait référence à un logger prédéfini associé au channel app
    public function __construct(LoggerInterface $databaseLogger) {
        $this->logger = $databaseLogger;
    }

    /**
     * @Route("/accueil", name="accueil")
     */
    public function index(): Response
    {
        $this->logger->info("Ceci est un message d'info !");
        return $this->render('accuei/index.html.twig', [
            'controller_name' => 'AccueilController',
        ]);
    }
}
