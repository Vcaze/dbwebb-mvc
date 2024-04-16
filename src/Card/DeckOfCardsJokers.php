<?php

namespace App\Card;

use App\Card\Card;

class DeckOfCardsJokers extends DeckOfCards
{
    public function __construct()
    {
        parent::__construct();

        for ($i = 0; $i < 3; $i++) {
            // create and add a joker Card to the deck
            $this->deck[] = new Card("&#x1F0BF", "Joker", "Joker");
        }
    }
}
