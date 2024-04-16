<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ControllerTwig extends AbstractController
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

    #[Route("/session", name: "session")]
    public function session(SessionInterface $session): Response
    {
        // get all data in session
        $sessionData = $session->all();

        // convert the session values to strings
        foreach ($sessionData as $key => $value) {
            if (is_object($value)) {
                $sessionData[$key] = (string)$value;
            }
        }

        $data = [
            'sessionData' => $sessionData,
        ];

        return $this->render('session.html.twig', $data);
    }

    #[Route("/session/delete", name: "session_delete")]
    public function sessionDelete(SessionInterface $session): Response
    {
        // clear session
        $session->clear();

        // get all data in session (should be none)
        $sessionData = $session->all();

        // convert the session values to strings
        foreach ($sessionData as $key => $value) {
            if (is_object($value)) {
                $sessionData[$key] = (string)$value;
            }
        }

        $data = [
            'sessionData' => $sessionData,
        ];

        // add flash message
        if (count($sessionData) === 0) {
            $this->addFlash(
                'notice',
                'All data i session har raderats'
            );
        } else {
            $this->addFlash(
                'warning',
                'Radera all data i session lyckades ej'
            );
        }

        return $this->render('session.html.twig', $data);
    }
}
