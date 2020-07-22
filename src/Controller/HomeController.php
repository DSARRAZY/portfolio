<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProjectRepository;

class HomeController extends AbstractController
{
    /**
     * Home page display
     * @Route("/",name="home_index")
     * @return Response A response instance
     */
    public function index(ProjectRepository $project) :Response
    {
        return $this->render('index.html.twig', [
            'projects' => $project->findAll(),
        ]);
    }
}
