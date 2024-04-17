<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

// use App\Card\Card;
// use App\Card\CardHand;
use App\Card\DeckOfCards;

// use App\Card\DeckOfCardsJokers;

class CardGameController extends AbstractController
{
    #[Route("/card", name: "card_start")]
    public function home(): Response
    {
        return $this->render('card/index.html.twig');
    }

    #[Route("/card/deck", name: "deck")]
    public function deck(
        SessionInterface $session
    ): Response {
        // get the deck
        $deck = $session->get("deck");

        if ($deck === null) {
            $deck = new DeckOfCards();
            $session->set("deck", $deck);
        }
        // sort the deck
        $deck->sort();

        // prepare the data
        $cards = $deck->getCards();
        $cardsSuits = [];
        foreach ($cards as $card) {
            $cardsSuits[] = strtolower($card-> getSuit());
        }
        // set the data for the template
        $data = [
            "cardsChars" => $deck->getCardsUnicodeChars(),
            "cardsSuits" => $cardsSuits,
        ];

        return $this->render('card/deck.html.twig', $data);
    }

    #[Route("/card/shuffle", name: "shuffle_deck")]
    public function shuffleDeck(
        SessionInterface $session
    ): Response {
        // get the deck
        $deck = $session->get("deck");

        if ($deck === null) {
            $deck = new DeckOfCards();
            $session->set("deck", $deck);
        }
        // shuffle the deck
        $deck->shuffle();

        // prepare the data
        $cards = $deck->getCards();
        $cardsSuits = [];
        foreach ($cards as $card) {
            $cardsSuits[] = strtolower($card-> getSuit());
        }
        // set the data for the template
        $data = [
            "cardsChars" => $deck->getCardsUnicodeChars(),
            "cardsSuits" => $cardsSuits,
        ];

        return $this->render('card/deck.html.twig', $data);
    }

    #[Route("/card/draw/{numCards<\d+>?1}", name: "draw")]
    public function draw(
        int $numCards,
        SessionInterface $session
    ): Response {
        // get the deck
        $deck = $session->get("deck");

        if ($deck === null) {
            $deck = new DeckOfCards();
            $session->set("deck", $deck);
        }
        // draw card(s) from the deck
        $cards = $deck->draw($numCards);
        // prepare data
        $cardsUnicodeChars = [];
        $cardsSuits = [];
        foreach ($cards as $card) {
            $cardsUnicodeChars[] = $card->getUnicodeChar();
            $cardsSuits[] = strtolower($card->getSuit());
        }
        // set the data for the template
        $data = [
            "cardsChars" => $cardsUnicodeChars,
            "cardsSuits" => $cardsSuits,
            "numCardsRemaining" => $deck->getNumberCards(),
        ];

        return $this->render('card/draw.html.twig', $data);
    }
}
