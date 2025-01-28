<?php

namespace App\Controller;

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
        //    recuperre les filier de la base de donne 
        $agences = $agenceRepository->findAll();

    //  dd($filieres);
    $agences  = $paginator->paginate(
        $agences, /* query NOT result */
        $request->query->getInt('page', 1), /* page number */
        5 /* limit per page */
    );


    return $this->render('agence/index.html.twig', [
                'agences' => $agences,
             ]);
    }

    


}
