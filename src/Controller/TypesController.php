<?php

namespace App\Controller;

use App\Entity\Types;
use App\Form\TypesType;
use App\Repository\TypesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/types')]
final class TypesController extends AbstractController
{
    #[Route(name: 'app_types_index', methods: ['GET'])]
    public function index(TypesRepository $typesRepository): Response
    {
        return $this->render('types/index.html.twig', [
            'types' => $typesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_types_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $type = new Types();
        $form = $this->createForm(TypesType::class, $type);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($type);
            $entityManager->flush();

            return $this->redirectToRoute('app_types_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('types/new.html.twig', [
            'type' => $type,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_types_show', methods: ['GET'])]
    public function show(Types $type): Response
    {
        return $this->render('types/show.html.twig', [
            'type' => $type,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_types_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Types $type, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TypesType::class, $type);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_types_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('types/edit.html.twig', [
            'type' => $type,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_types_delete', methods: ['POST'])]
    public function delete(Request $request, Types $type, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$type->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($type);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_types_index', [], Response::HTTP_SEE_OTHER);
    }
}
