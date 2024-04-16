<?php

namespace App\Card;

use App\Card\Card;
use phpDocumentor\Reflection\Types\Void_;

class DeckOfCards
{
    private $deck = [];

    public function __construct()
    {
        $this->fillDeck();
    }

    public function getNumberCards(): int
    {
        return count($this->deck);
    }

    public function getCardsUnicodeChars(): array
    {
        $cardChars = [];
        foreach ($this->deck as $card) {
            $cardChars[] = $card->getUnicodeChar();
        }
        return $cardChars;
    }

    public function getCards(): array
    {
        return $this->deck;
    }

    public function shuffle(): void
    {
        shuffle($this->deck);
    }

    public function draw(int $amount = 1): array
    {
        $numCardsRemaning = $this->getNumberCards();
        if ($amount > $numCardsRemaning) {
            $amount = $numCardsRemaning;
        }
        $cards = [];
        for ($i = 0; $i < $amount; $i++) {
            $randomIndex = rand(0, $numCardsRemaning - 1);
            $cards[] = $this->deck[$randomIndex];
            array_splice($this->deck, $randomIndex, 1);
            $numCardsRemaning--;
        }
        return $cards;
    }

    public function sort(): void
    {
        usort($this->deck, function($cardA, $cardB){
            return strcmp($cardA->getUnicodeChar(), $cardB->getUnicodeChar());
        });
    }

    public function reset(): void
    {
        $this->deck = [];
        $this->fillDeck();
    }

    private function fillDeck(): void
    {
        $unicodeCharBase = "&#x1F0";
        $suitUnicodeChars = ["A", "B", "C", "D"];
        $rankUnicodeChars = ["1", "2", "3", "4", "5", "6", "7", "8", "9", "A", "B", "D", "E"];
        $suitValues = ["Spades", "Hearts", "Diamonds", "Clubs"];
        $rankValues = ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "J", "Q", "K"];
        for ($i = 0; $i < 52; $i++) {
            $quotient = (int)($i / 13); // Will be 0-3
            $remainder = $i % 13; // Will be 0-12
            $unicodeChar = $unicodeCharBase . $suitUnicodeChars[$quotient] . $rankUnicodeChars[$remainder];
            $card = new Card($unicodeChar, $suitValues[$quotient], $rankValues[$remainder]);
            $this->deck[] = $card;
        }
    }

    public function __toString()
    {
        return '*DeckOfCards Object*';
    }
}
