<?php

namespace App\Controller;

use App\Form\AgenceSearchType;
use App\Repository\AgenceRepository;
use ContainerUyhNUxr\getAgenceRepositoryService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AgenceController extends AbstractController
{
    #[Route('/agence/liste', name: 'app_agence',methods:['GET'])]
    public function index( AgenceRepository $agenceRepository , PaginatorInterface $paginator  ,Request $request): Response
    {
    //     //    recuperre les filier de la base de donne 
    //     $agences = $agenceRepository->findAll();

    // //  dd($filieres);
    // $agences  = $paginator->paginate(
    //     $agences, /* query NOT result */
    //     $request->query->getInt('page', 1), /* page number */
    //     5 /* limit per page */
    // );


    // return $this->render('agence/index.html.twig', [
    //             'agences' => $agences,
    //          ]);


      // Création du formulaire de recherche
      $form = $this->createForm(AgenceSearchType::class);
      $form->handleRequest($request);

      // Récupérer les données filtrées
      $filters = $form->getData();

      // Appliquer les filtres à la requête
      $queryBuilder = $agenceRepository->createQueryBuilder('a');

      // Filtrer par téléphone si le champ est rempli et existe
      if (isset($filters['telephone']) && $filters['telephone']) {
          $queryBuilder->andWhere('a.telephone LIKE :telephone')
                       ->setParameter('telephone', '%' . $filters['telephone'] . '%');
      }

      // Filtrer par adresse si le champ est rempli et existe
      if (isset($filters['adresse']) && $filters['adresse']) {
          $queryBuilder->andWhere('a.adresse LIKE :adresse')
                       ->setParameter('adresse', '%' . $filters['adresse'] . '%');
      }

      // Récupérer les résultats filtrés
      $agences = $queryBuilder->getQuery()->getResult();

      // Appliquer la pagination sur les résultats filtrés
      $agences = $paginator->paginate(
          $agences, /* query NOT result */
          $request->query->getInt('page', 1), /* page number */
          5 /* limit per page */
      );

      // Retourner la vue avec le formulaire et les agences paginées
      return $this->render('agence/index.html.twig', [
          'form' => $form->createView(),
          'agences' => $agences,
      ]);
  }
  
  }
    

    



