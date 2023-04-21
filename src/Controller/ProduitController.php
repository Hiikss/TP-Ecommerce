<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\LigneCommande;
use App\Form\LigneCommandeType;
use App\Repository\ProduitRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProduitController extends AbstractController
{
    #[Route('/produit/{id}', name: 'produit_details')]
    public function details(int $id, ProduitRepository $produitRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $produit = $produitRepository->find($id);

        $ligneCommande = new LigneCommande();
        $ligneCommande->setProduit($produit);

        $ligneForm = $this->createForm(LigneCommandeType::class, $ligneCommande);

        $ligneForm->handleRequest($request);

        if($ligneForm->isSubmitted() && $ligneForm->isValid()) {
            $panier = new Commande();

            /*if(!$request->cookies->get('panier')) {
                $panier->setDateCommande(new DateTime());
                $panier->setStatut('non validé');

                if($this->getUser()) {
                    dd('connecté');
                    $panier->setPasse($this->getUser());
                }
                else {
                    dd('non connecté');
                }
            }
            else {
                $panier = unserialize($request->cookies->get('panier'));
            }
            $panier->addLigneCommande($ligneCommande);
            $ligneCommande->setCommande($panier);

            $response = new Response();
            $response->headers->setCookie(new Cookie('panier', serialize($panier), time() + (31*24*60*60)));
            $response->send();*/

            $entityManager->persist($ligneCommande);
            $entityManager->flush();

            $this->addFlash('success', '');
            return $this->redirectToRoute('main_home');
        }

        if(!$produit) {
            throw $this->createNotFoundException();
        }

        return $this->render('produit/index.html.twig', [
            'produit' => $produit,
            'ligneForm' => $ligneForm->createView()
        ]);
    }
}
