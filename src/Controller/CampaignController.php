<?php

namespace App\Controller;

use App\Entity\Campaign;
use App\Entity\Participant;
use App\Entity\Payment;
use App\Form\CampaignType;
use App\Form\PaymentType;
use App\Repository\CampaignRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/campaign')]
class CampaignController extends AbstractController
{
    #[Route('/', name: 'app_campaign_index', methods: ['GET'])]
    public function index(CampaignRepository $campaignRepository): Response
    {
        return $this->render('campaign/index.html.twig', [
            'campaigns' => $campaignRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_campaign_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $campaign = new Campaign();
        $form = $this->createForm(CampaignType::class, $campaign);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $campaign->setCustomId();
            $entityManager->persist($campaign);
            $entityManager->flush();

            return $this->redirectToRoute('app_campaign_show', ["id" => $campaign->getId()], Response::HTTP_SEE_OTHER);
        }
        //dd($form);
        return $this->render('campaign/new.html.twig', [
            'campaign' => $campaign,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_campaign_show', methods: ['GET'])]
    public function show(Campaign $campaign): Response
    {
        $particiants = $campaign->getParticipants()->getValues();
        $nbParticipants = sizeof($particiants);
        $totalFounding = 0;
        foreach($particiants as $participant){
            if(!empty($participant->getPayments()->getValues()[0]))
                $totalFounding += $participant->getPayments()->getValues()[0]->getAmount();
        }
        $percentCampaign = $totalFounding * 100 / $campaign->getGoal();

        return $this->render('campaign/show.html.twig', [
            'campaign' => $campaign,
            'participants' => $particiants,
            'percentCampaign' => round($percentCampaign),
            'nbParticipants' => $nbParticipants,
            'totalFounding' => $totalFounding
        ]);
    }
    
    #[Route('/{id}/payment', name: 'app_campaign_payment', methods: ['GET'])]
    public function showPayment(Request $request, Campaign $campaign): Response
    {
        $particiants = $campaign->getParticipants()->getValues();
        $payment = new Payment();
        $form = $this->createForm(PaymentType::class, $payment);

        if ($form->isSubmitted() && $form->isValid()) {
            $form->handleRequest($request);
            return $this->redirectToRoute('app_campaign_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('payment/new.html.twig', [
            'campaign' => $campaign,
            'form' => $form,
            'participants' => $particiants
        ]);
    }

    #[Route('/{id}/edit', name: 'app_campaign_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Campaign $campaign, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CampaignType::class, $campaign);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_campaign_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('campaign/edit.html.twig', [
            'campaign' => $campaign,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_campaign_delete', methods: ['POST'])]
    public function delete(Request $request, Campaign $campaign, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$campaign->getId(), $request->request->get('_token'))) {
            $entityManager->remove($campaign);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_campaign_index', [], Response::HTTP_SEE_OTHER);
    }
}
