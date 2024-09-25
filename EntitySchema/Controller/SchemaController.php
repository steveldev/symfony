<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse; 
use Symfony\Component\Routing\Attribute\Route;

use App\Service\EntitySchema;

class SchemaController extends AbstractController
{
    private $entitySchema;

    public function __construct(EntitySchema $entitySchema) {
        $this->entitySchema = $entitySchema;
    }
    
    #[Route(path: '/api/{entity}/schema', name: 'api_entity_schema', methods: ['GET'])] 
    public function api_entity_schema($entity) {
        $schema = $this->entitySchema->getEntitySchema($entity);
        return new JsonResponse($schema, 200, []);
    }
}
