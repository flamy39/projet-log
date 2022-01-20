<?php

namespace App\Controller;

use App\Entity\Film;
use App\Repository\FilmRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\DocBlock\Serializer;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class FilmController extends AbstractController
{
    private SerializerInterface $serializer;
    private LoggerInterface $logger;
    private EntityManagerInterface $entityManager;
    private FilmRepository $filmRepository;

    public function __construct(SerializerInterface $serializer,
                                LoggerInterface $databaseLogger,
                                EntityManagerInterface $entityManager,
                                FilmRepository $filmRepository) {
        $this->serializer = $serializer;
        $this->logger = $databaseLogger;
        $this->entityManager = $entityManager;
        $this->filmRepository = $filmRepository;
    }

    /**
     * @Route("/api/films", name="api_films_create", methods={"POST"})
     */
    public function createFilm(RequestStack $requestStack): Response
    {
        // Récupérer le contenu de la requête
        $filmRequestJson = $requestStack->getCurrentRequest()->getContent();
        // Désérialiser le json en un objet film
        $film = $this->serializer->deserialize($filmRequestJson,Film::class,"json");

        // Logger (le nom du film est passé dans le contexte)
        $this->logger->info("Post : ajoût du film",["film" => $film->getTitre()]);
        // Insertion dans la base de données
        $this->entityManager->persist($film);
        $this->entityManager->flush();
        // Génération de la réponse
        $filmResponseJson = $this->serializer->serialize($film,'json');
        return new JsonResponse($filmResponseJson,Response::HTTP_CREATED,[],true);
    }

    /**
     * @Route("/api/films", name="api_films_get", methods={"GET"})
     */
    public function getFilms(): Response {

        // Logger
        $this->logger->info("Get : liste des films");
        // Récupérer la liste des films
        $films = $this->filmRepository->findAll();
        // Génération de la réponse
        $filmsResponseJson = $this->serializer->serialize($films,"json");
        return new JsonResponse($filmsResponseJson,Response::HTTP_CREATED,[],true);
    }

}
