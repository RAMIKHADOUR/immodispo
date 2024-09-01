<?php

namespace App\Controller;

use App\Entity\Prices;
use App\Form\PricesType;
use App\Repository\PricesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/prices')]
final class PricesController extends AbstractController
{
    #[Route(name: 'app_prices_index', methods: ['GET'])]
    public function index(PricesRepository $pricesRepository): Response
    {
        return $this->render('prices/index.html.twig', [
            'prices' => $pricesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_prices_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $price = new Prices();
        $form = $this->createForm(PricesType::class, $price);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($price);
            $entityManager->flush();

            return $this->redirectToRoute('app_prices_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('prices/new.html.twig', [
            'price' => $price,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_prices_show', methods: ['GET'])]
    public function show(Prices $price): Response
    {
        return $this->render('prices/show.html.twig', [
            'price' => $price,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_prices_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Prices $price, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PricesType::class, $price);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_prices_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('prices/edit.html.twig', [
            'price' => $price,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_prices_delete', methods: ['POST'])]
    public function delete(Request $request, Prices $price, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$price->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($price);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_prices_index', [], Response::HTTP_SEE_OTHER);
    }
}
