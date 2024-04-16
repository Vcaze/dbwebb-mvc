<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\KernelInterface;

class ControllerJson extends AbstractController
{
    private $kernel;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    #[Route("/api/lucky/number")]
    public function jsonNumber(): Response
    {
        $number = random_int(0, 100);

        $data = [
            'lucky-number' => $number,
            'lucky-message' => 'Hi there!',
        ];

        // return new JsonResponse($data);

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[route("/api/quote")]
    public function quote(): Response
    {
        $projectDir = $this->kernel->getProjectDir();
        $jsonFile = file_get_contents($projectDir . '/public/data/quotes.json');

        $quotes = json_decode($jsonFile, true)['quotes'];
        $randomQuote = $quotes[array_rand($quotes)];

        date_default_timezone_set('Europe/Stockholm');
        $curDateAndTime = date('Y-m-d H:i:s');

        $quoteMsg  = sprintf('"%s" - %s', $curDateAndTime, $randomQuote);

        $response = new JsonResponse($quoteMsg);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
}
