<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HealthCheckController extends AbstractController
{
    #[Route('/health', name: 'app_health_check')]
    public function index(): Response
    {
        return $this->render('health_check/index.html.twig', [
            'controller_name' => 'HealthCheckController',
        ]);
    }
}
