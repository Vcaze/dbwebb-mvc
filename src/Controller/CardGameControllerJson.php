<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use App\Card\DeckOfCards;

class CardGameControllerJson extends AbstractController
{
    //     private $kernel;
    //
    //     public function __construct(KernelInterface $kernel)
    //     {
    //         $this->kernel = $kernel;
    //     }

    #[route("/api/deck")]
    public function deck(
        SessionInterface $session
    ): Response {
        $deck = $session->get("deck");

        if ($deck === null) {
            $deck = new DeckOfCards();
            $session->set("deck", $deck);
        }

        $deck->sort();

        $cards = $deck->getCards();

        $cardsData = [];
        foreach ($cards as $card) {
            $cardsData[] = [
                'unicodeChar' => $card->getUnicodeChar(),
                'suit' => $card->getSuit(),
                'rank' => $card->getRank(),
                'rankInt' => $card->getRankInt(),
            ];
        }

        // $cardsEncoded = json_encode($cards);

        $response = new JsonResponse($cardsData);

        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[route("/api/deck/shuffle")]
    public function shuffleDeck(
        SessionInterface $session
    ): Response {
        $deck = $session->get("deck");

        if ($deck === null) {
            $deck = new DeckOfCards();
            $session->set("deck", $deck);
        }

        $deck->shuffle();

        $cards = $deck->getCards();

        $cardsData = [];
        foreach ($cards as $card) {
            $cardsData[] = [
                'unicodeChar' => $card->getUnicodeChar(),
                'suit' => $card->getSuit(),
                'rank' => $card->getRank(),
                'rankInt' => $card->getRankInt(),
            ];
        }

        // $cardsEncoded = json_encode($cards);

        $response = new JsonResponse($cardsData);

        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[route("/api/deck/draw/{numCards<\d+>?1}")]
    public function draw(
        int $numCards,
        SessionInterface $session
    ): Response {
        $deck = $session->get("deck");

        if ($deck === null) {
            $deck = new DeckOfCards();
            $session->set("deck", $deck);
        }

        $cards = $deck->draw($numCards);

        $cardsData = [];
        foreach ($cards as $card) {
            $cardsData[] = [
                'unicodeChar' => $card->getUnicodeChar(),
                'suit' => $card->getSuit(),
                'rank' => $card->getRank(),
                'rankInt' => $card->getRankInt()
            ];
        }

        $data = [
            'cards' => $cardsData,
            'cardsRemaning' => $deck->getNumberCards(),
        ];
        // $cardsEncoded = json_encode($cards);

        $response = new JsonResponse($data);

        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
}
