<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LuckyControllerTwig extends AbstractController
{
    #[Route("/", name: "home")]
    public function home(): Response
    {
        return $this->render('home.html.twig');
    }

    #[Route("/about", name: "about")]
    public function about(): Response
    {
        return $this->render('about.html.twig');
    }

    #[Route("/report", name: "report")]
    public function report(): Response
    {
        return $this->render('report.html.twig');
    }

    #[Route("/lucky", name: "lucky")]
    public function lucky(): Response
    {
        return $this->render('lucky.html.twig');
    }

    #[Route("/api", name: "api")]
    public function api(): Response
    {
        $jsonFile = file_get_contents($this->getParameter('kernel.project_dir') . '/public/data/api_routes.json');
        
        $routes = json_decode($jsonFile, true)['routes'];
 
        return $this->render('api.html.twig', [
             'routes' => $routes,
        ]);
    }
}
