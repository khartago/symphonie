<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ServiceController extends AbstractController
{
     #[Route('/service/go-to-index', name: 'app_service_go_to_index')]
    public function goToIndex(): Response
    {
        return $this->redirectToRoute('app_home');
    }


    #[Route('/service/{name}', name: 'app_service')]
    public function showService(string $name): Response
    {
        return $this->render('service/showService.html.twig', [
            'name' => $name,
        ]);
    }

   
}
