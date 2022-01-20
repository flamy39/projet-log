<?php

namespace App\Log;

use App\Entity\Log;
use Doctrine\ORM\EntityManagerInterface;
use Monolog\Handler\AbstractProcessingHandler;

class DatabaseHandler extends AbstractProcessingHandler
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function write(array $record): void
    {
        // Enregistrer le $record dans la base de données (table log)
        $log = new Log();
        $log->setMessage($record["message"]);
        $log->setChannel($record["channel"]);
        $log->setLevel($record["level"]);
        $log->setLevelName($record["level_name"]);
        $log->setContext($record["context"]);
        $log->setExtra($record["extra"]);
        $log->setCreatedAt(new \DateTime());
        $log->setUser($record["extra"]["user"]);

        // Ecrire le log dans la table log
        $this->entityManager->persist($log);
        $this->entityManager->flush();
    }
}