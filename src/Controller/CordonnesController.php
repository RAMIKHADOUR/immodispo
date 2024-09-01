<?php

namespace App\Controller;

use App\Entity\Cordonnes;
use App\Form\CordonnesType;
use App\Repository\CordonnesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/cordonnes')]
final class CordonnesController extends AbstractController
{
    #[Route(name: 'app_cordonnes_index', methods: ['GET'])]
    public function index(CordonnesRepository $cordonnesRepository): Response
    {
        return $this->render('cordonnes/index.html.twig', [
            'cordonnes' => $cordonnesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_cordonnes_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $cordonne = new Cordonnes();
        $form = $this->createForm(CordonnesType::class, $cordonne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($cordonne);
            $entityManager->flush();

            return $this->redirectToRoute('app_cordonnes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('cordonnes/new.html.twig', [
            'cordonne' => $cordonne,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_cordonnes_show', methods: ['GET'])]
    public function show(Cordonnes $cordonne): Response
    {
        return $this->render('cordonnes/show.html.twig', [
            'cordonne' => $cordonne,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_cordonnes_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Cordonnes $cordonne, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CordonnesType::class, $cordonne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_cordonnes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('cordonnes/edit.html.twig', [
            'cordonne' => $cordonne,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_cordonnes_delete', methods: ['POST'])]
    public function delete(Request $request, Cordonnes $cordonne, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cordonne->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($cordonne);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_cordonnes_index', [], Response::HTTP_SEE_OTHER);
    }
}
