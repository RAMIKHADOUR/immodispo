<?php

namespace App\Controller;

use App\Entity\Descriptions;
use App\Form\DescriptionsType;
use App\Repository\DescriptionsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/descriptions')]
final class DescriptionsController extends AbstractController
{
    #[Route(name: 'app_descriptions_index', methods: ['GET'])]
    public function index(DescriptionsRepository $descriptionsRepository): Response
    {
        return $this->render('descriptions/index.html.twig', [
            'descriptions' => $descriptionsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_descriptions_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $description = new Descriptions();
        $form = $this->createForm(DescriptionsType::class, $description);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($description);
            $entityManager->flush();

            return $this->redirectToRoute('app_descriptions_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('descriptions/new.html.twig', [
            'description' => $description,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_descriptions_show', methods: ['GET'])]
    public function show(Descriptions $description): Response
    {
        return $this->render('descriptions/show.html.twig', [
            'description' => $description,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_descriptions_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Descriptions $description, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DescriptionsType::class, $description);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_descriptions_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('descriptions/edit.html.twig', [
            'description' => $description,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_descriptions_delete', methods: ['POST'])]
    public function delete(Request $request, Descriptions $description, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$description->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($description);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_descriptions_index', [], Response::HTTP_SEE_OTHER);
    }
}
