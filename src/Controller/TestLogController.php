<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestLogController extends AbstractController
{
    #[Route('/test-log', name: 'app_test_log')]
    public function index(LoggerInterface $logger): Response
    {
        $logger->info('Esto es un log de prueba.');
        return $this->render('test_log/index.html.twig', [
            'controller_name' => 'TestLogController',
        ]);
    }
}


