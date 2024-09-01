<?php

namespace App\Controller;

use App\Entity\Installations;
use App\Form\InstallationsType;
use App\Repository\InstallationsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/installations')]
final class InstallationsController extends AbstractController
{
    #[Route(name: 'app_installations_index', methods: ['GET'])]
    public function index(InstallationsRepository $installationsRepository): Response
    {
        return $this->render('installations/index.html.twig', [
            'installations' => $installationsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_installations_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $installation = new Installations();
        $form = $this->createForm(InstallationsType::class, $installation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($installation);
            $entityManager->flush();

            return $this->redirectToRoute('app_installations_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('installations/new.html.twig', [
            'installation' => $installation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_installations_show', methods: ['GET'])]
    public function show(Installations $installation): Response
    {
        return $this->render('installations/show.html.twig', [
            'installation' => $installation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_installations_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Installations $installation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(InstallationsType::class, $installation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_installations_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('installations/edit.html.twig', [
            'installation' => $installation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_installations_delete', methods: ['POST'])]
    public function delete(Request $request, Installations $installation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$installation->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($installation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_installations_index', [], Response::HTTP_SEE_OTHER);
    }
}
