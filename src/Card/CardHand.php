<?php

namespace App\Card;

use App\Card\Card;

class CardHand
{
    /**
     * @var array
     */
    private $hand = [];

    public function add(Card $card): void
    {
        $this->hand[] = $card;
    }

    public function getNumberCards(): int
    {
        return count($this->hand);
    }

    public function getUnicodeChars(): array
    {
        $chars = [];
        foreach ($this->hand as $card) {
            $chars[] = $card->getUnicodeChar();
        }
        return $chars;
    }
}
