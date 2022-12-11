<?php

namespace App\Controller;

use App\Entity\BankService;
use App\Form\BankServiceType;
use App\Repository\BankServiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/bankservice')]
class BankServiceController extends AbstractController
{
    #[Route('/', name: 'app_bank_service_index', methods: ['GET'])]
    public function index(BankServiceRepository $bankServiceRepository): Response
    {
        return $this->render('bank_service/index.html.twig', [
            'bank_services' => $bankServiceRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_bank_service_new', methods: ['GET', 'POST'])]
    public function new(Request $request, BankServiceRepository $bankServiceRepository): Response
    {
        $bankService = new BankService();
        $form = $this->createForm(BankServiceType::class, $bankService);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bankServiceRepository->save($bankService, true);

            return $this->redirectToRoute('app_bank_service_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('bank_service/new.html.twig', [
            'bank_service' => $bankService,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_bank_service_show', methods: ['GET'])]
    public function show(BankService $bankService): Response
    {
        return $this->render('bank_service/show.html.twig', [
            'bank_service' => $bankService,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_bank_service_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, BankService $bankService, BankServiceRepository $bankServiceRepository): Response
    {
        $form = $this->createForm(BankServiceType::class, $bankService);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bankServiceRepository->save($bankService, true);

            return $this->redirectToRoute('app_bank_service_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('bank_service/edit.html.twig', [
            'bank_service' => $bankService,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_bank_service_delete', methods: ['POST'])]
    public function delete(Request $request, BankService $bankService, BankServiceRepository $bankServiceRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bankService->getId(), $request->request->get('_token'))) {
            $bankServiceRepository->remove($bankService, true);
        }

        return $this->redirectToRoute('app_bank_service_index', [], Response::HTTP_SEE_OTHER);
    }
}