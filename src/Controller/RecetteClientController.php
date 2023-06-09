<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use App\Entity\Recette;
use App\Entity\Avis;
use App\Form\AvisType;
use App\Repository\AvisRepository;
use App\Form\RecetteType;
use App\Repository\RecetteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/recetteClient')]
class RecetteClientController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/recette/client', name: 'app_recette_client')]
    public function index(): Response
    {
        return $this->render('recette_client/index.html.twig', [
            'controller_name' => 'RecetteClientController',
        ]);
    }

    #[Route('/', name: 'app_recette_client_index', methods: ['GET'])]
    public function view(RecetteRepository $recetteRepository): Response
    {
        return $this->render('recette_client/index.html.twig', [
            'recettes' => $recetteRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_recette_client_show', methods: ['GET','POST'])]
    public function show(Recette $recette, Request $request): Response
    {
        $patient = $this->getUser();
       // Créer une instance de l'entité Avis
       $avis = new Avis();

       // Créer le formulaire pour l'avis
       $form = $this->createForm(AvisType::class, $avis);


       $form->handleRequest($request);
       if ($form->isSubmitted() && $form->isValid()) {

           $avis->setUser($patient);

           $avis->setRecette($recette);

           $this->entityManager->persist($avis);
           $this->entityManager->flush();
       }
       return $this->render('recette_client/show.html.twig', [
           'recette' => $recette,
           'form' => $form->createView(),

       ]);

    }

}
