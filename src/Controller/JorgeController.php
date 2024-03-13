<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class JorgeController extends AbstractController
{

    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('jorge/index.html.twig', [
        ]);

    }
    #[Route('/create', name: 'create')]
    public function create(): Response
    {
        return $this->render('jorge/create.html.twig', [
        ]);

    }
    #[Route('/payment', name: 'payment')]
    public function payment(): Response
    {
        return $this->render('jorge/payment.html.twig', [
        ]);

    }
    #[Route('/show', name: 'show')]
    public function homeShow(): Response
    {
        return $this->redirectToRoute('app_campaign_index', [], Response::HTTP_SEE_OTHER);

    }
}
