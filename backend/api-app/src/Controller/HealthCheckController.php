<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HealthCheckController extends AbstractController
{
    #[Route('/health', name: 'app_health_check', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return $this->json([
            'status' => 'OK',
            'timestamp' => (new \DateTime())->format('Y-m-d H:i:s'),
        ]);
    }
}
