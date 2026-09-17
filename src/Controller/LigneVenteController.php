<?php

namespace App\Controller;

use App\Entity\LigneVente;
use App\Form\LigneVenteType;
use App\Repository\LigneVenteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/ligne/vente')]
final class LigneVenteController extends AbstractController
{
    #[Route(name: 'app_ligne_vente_index', methods: ['GET'])]
    public function index(LigneVenteRepository $ligneVenteRepository): Response
    {
        return $this->render('ligne_vente/index.html.twig', [
            'ligne_ventes' => $ligneVenteRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_ligne_vente_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $ligneVente = new LigneVente();
        $form = $this->createForm(LigneVenteType::class, $ligneVente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($ligneVente);
            $entityManager->flush();

            return $this->redirectToRoute('app_ligne_vente_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ligne_vente/new.html.twig', [
            'ligne_vente' => $ligneVente,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ligne_vente_show', methods: ['GET'])]
    public function show(LigneVente $ligneVente): Response
    {
        return $this->render('ligne_vente/show.html.twig', [
            'ligne_vente' => $ligneVente,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_ligne_vente_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, LigneVente $ligneVente, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LigneVenteType::class, $ligneVente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_ligne_vente_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ligne_vente/edit.html.twig', [
            'ligne_vente' => $ligneVente,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ligne_vente_delete', methods: ['POST'])]
    public function delete(Request $request, LigneVente $ligneVente, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ligneVente->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($ligneVente);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_ligne_vente_index', [], Response::HTTP_SEE_OTHER);
    }
}
