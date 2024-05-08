<?php

namespace App\Card;

use App\Card\DeckOfCards;

class TwentyOne
{
    /**
     * @var DeckOfCards
     */
    public $deck;
    /**
     * @var array
     */
    private $cardsDrawn = [];
    /**
     * @var int
     */
    private $playerScore;
    /**
     * @var int
     */
    private $bankScore;
    /**
     * @var string
     */
    private $status;

    public function __construct()
    {
        $this->deck = new DeckOfCards();
        $this->playerScore = 0;
        $this->bankScore = 0;
        $this->status = "play";
    }

    public function draw($playerDrawing = false, $retunOneCard = false)
    {
        $card = $this->deck->draw()[0];
        $this->scoreCard($card, $playerDrawing);
        $this->cardsDrawn[] = $card;

        if ($retunOneCard) {
            return $card;
        }

        return $this->cardsDrawn;
    }

    public function scoreCard($card, $isPlayersCard)
    {
        $score = $isPlayersCard ? $this->playerScore : $this->bankScore;
        $cardValue = $card->getRankInt();

        if ($cardValue === 1 && $score + 14 <= 21) {
            $cardValue = 14;
        }

        $score += $cardValue;

        if ($score > 21) {
            $score = 0;
        }

        if ($isPlayersCard) {
            $this->playerScore = $score;
            if ($score === 0) {
                $this->status = "finished";
            }
        } else {
            $this->bankScore = $score;
        }
    }

    public function autoPlay()
    {
        $roundsData = [];

        while ($this->bankScore < 15) {
            $roundsData[] = [
                'card' => $this->draw(false, true),
                'score' =>  $this->bankScore,
            ];
        }

        $this->status = "finished";

        return $roundsData;
    }

    public function getPlayerScore()
    {
        return $this->playerScore;
    }

    public function getBankScore()
    {
        return $this->bankScore;
    }

    public function getCardsDrawn()
    {
        return $this->cardsDrawn;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function reset()
    {
        $this->deck->reset();
        $this->playerScore = 0;
        $this->bankScore = 0;
        $this->cardsDrawn = [];
        $this->status = "play";
    }
}
