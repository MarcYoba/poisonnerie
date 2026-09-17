<?php

namespace App\Controller;

use App\Entity\Achat;
use App\Entity\LigneVente;
use App\Entity\Vente;
use App\Form\VenteType;
use App\Repository\VenteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/vente')]
final class VenteController extends AbstractController
{
    #[Route(('/list'),name: 'app_vente_index', methods: ['GET'])]
    public function index(VenteRepository $venteRepository): Response
    {
        return $this->render('vente/index.html.twig', [
            'ventes' => $venteRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_vente_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $vente = new Vente();
        $form = $this->createForm(VenteType::class, $vente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $motant = $form->get('montantTotalHt')->getData();
            $remise = $form->get('remise')->getData();
            $status = $form->get('statuspaiement')->getData();
            $numroFacture = $form->get('numeroFacture')->getData();
            $vente = new Vente();
            $vente->setNumeroFacture($numroFacture);
            $vente->setMontantTotalTtc(0);
            $vente->setMontantTotalHt($motant);
            $vente->setMontantTva(0);
            $vente->setRemise($remise);
            $vente->setUser($this->getUser());
            $vente->setCreatetAt(new \DateTime());
            $vente->setStatuspaiement($status);

            $lignesSoumises = $form->get('lignes')->getData();

            // 2. Parcourir et associer manuellement chaque LigneVente à la Vente
            foreach ($lignesSoumises as $ligneVente) {
                
                // Option A : En utilisant la méthode de l'entité Vente (recommandé)
                $quantite = $ligneVente->getQuantitePoids();
                $produit = $ligneVente->getProduit();
                $qtproduit = $produit->getQuantite();
                $produit->setQuantite($qtproduit - $quantite);
                $entityManager->persist($produit);
                $vente->addLigneVente($ligneVente);
                // Option B : Ou en la liant directement si vous n'utilisez pas addLigneVente
                // $ligneVente->setVente($vente);
                // $em->persist($ligneVente);
            }// Debugging line to inspect the $lignesArray

            // Création de la première ligne
            
            // Création de la deuxième ligne

            // Ajout des lignes à la vente via addLigneVente()
        // Debugging line to inspect the $vente object
            $entityManager->persist($vente);
            $entityManager->flush();

            return $this->redirectToRoute('app_vente_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('vente/new.html.twig', [
            'vente' => $vente,
            'form' => $form,
        ]);
    }

    #[Route('show/{id}', name: 'app_vente_show', methods: ['GET'])]
    public function show(Vente $vente): Response
    {
        return $this->render('vente/show.html.twig', [
            'vente' => $vente,
        ]);
    }

    #[Route('edit/{id}', name: 'app_vente_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Vente $vente, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(VenteType::class, $vente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_vente_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('vente/edit.html.twig', [
            'vente' => $vente,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_vente_delete', methods: ['POST'])]
    public function delete(Request $request, Vente $vente, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$vente->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($vente);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_vente_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/benefice/{id}', name: 'app_vente_benefice', methods: ['GET'])]
    public function benefice(Vente $vente, EntityManagerInterface $entityManager): Response
    {
        $lignesVente = $vente->getLigneVentes();

        $benefice = [];
        foreach ($lignesVente as $ligne) {
            $produit = $ligne->getProduit();
            $achat = $entityManager->getRepository(Achat::class)->findOneBy(['produit' => $produit], ['id' => 'DESC']);
        $prixAchat = $achat?->getPrix() ?? 0;
            $prixVente = $ligne->getPrixUnitaire()?? 0;
            $quantite = $ligne->getQuantitePoids() ?? 0;
            array_push($benefice, [
                'produit' => $produit->getNomCommercial(),
                'prixAchat' => $prixAchat,
                'prixVente' => $prixVente,
                'quantite' => $quantite,
                'benefice' => ($prixVente - $prixAchat) * $quantite,
            ]);
        }
        return $this->render('vente/benefice.html.twig', [
            'vente' => $vente,
            'benefice' => $benefice,
        ]);
    }
}
