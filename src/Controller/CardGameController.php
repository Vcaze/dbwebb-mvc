<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use App\Card\DeckOfCards;
use App\Card\TwentyOne;

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


    #[route("/game", name: "twenty_one")]
    public function twentyOneHome(): Response
    {
        return $this->render('card/twenty_one_home.html.twig');
    }

    #[route("/tjugoett/init", name: "twenty_one_init")]
    public function twentyOneInit(
        SessionInterface $session
    ): Response {
        $twentyOne = new TwentyOne();
        $session->set("twenty_one", $twentyOne);
        $session->set("player_cards", []);
        $session->set("bank_play_data", []);

        return $this->redirectToRoute('twenty_one_play');
    }

    #[route("/tjugoett/play", name: "twenty_one_play")]
    public function twentyOnePlay(
        SessionInterface $session
    ): Response {
        $twentyOne = $session->get("twenty_one");
        $playerCards = $session->get("player_cards");
        $bankPlayData = $session->get("bank_play_data");

        if ($twentyOne === null) {
            return $this->redirectToRoute('twenty_one_init');
        }

        $bankScore = count($bankPlayData) > 0 ? end($bankPlayData)["score"] : "-";

        $data = [
            'status' => $twentyOne->getStatus(),
            'playerCards' => $playerCards,
            'bankPlayData' => $bankPlayData,
            "playerScore" => $twentyOne->getPlayerScore(),
            "bankScore" => $bankScore,
        ];

        return $this->render('card/twenty_one_play.html.twig', $data);
    }

    #[route("/tjugoett/draw", name: "twenty_one_draw", methods: ['POST'])]
    public function twentyOneDraw(
        SessionInterface $session
    ): Response {
        $twentyOne = $session->get("twenty_one");
        $cards = $twentyOne->draw(true, false);
        $session->set("player_cards", $cards);

        return $this->redirectToRoute('twenty_one_play');
    }

    #[route("/tjugoett/stay", name: "twenty_one_stay", methods: ['POST'])]
    public function twentyOneStay(
        SessionInterface $session
    ): Response {
        $twentyOne = $session->get("twenty_one");
        $twentyOne->setStatus("stay");

        return $this->redirectToRoute('twenty_one_play');
    }

    #[route("/tjugoett/bank_play", name: "twenty_one_bank_play", methods: ['POST'])]
    public function twentyOneBankPlay(
        SessionInterface $session
    ): Response {
        $twentyOne = $session->get("twenty_one");
        $bankPlayData = $twentyOne->autoPlay();
        $session->set("bank_play_data", $bankPlayData);

        return $this->redirectToRoute('twenty_one_play');
    }

    #[route("/game/doc", name: "twenty_one_doc")]
    public function twentyOneDoc(): Response
    {
        return $this->render('card/twenty_one_doc.html.twig');
    }
}
