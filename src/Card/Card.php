<?php

namespace App\Card;

class Card
{
    private $unicodeChar;
    private $suit;
    private $rank;

    private $rankInt;

    public function __construct(string $unicodeChar, string $suit, string $rank)
    {
        $this->unicodeChar = $unicodeChar;
        $this->suit = $suit;
        $this->rank = $rank;
        $rankInt = null;
        if (intval($rank) > 0  && intval($rank) <= 10) {
            $rankInt = intval($rank);
        } else {
            switch ($rank) {
                case "J":
                    $rankInt = 11;
                    break;
                case "Q":
                    $rankInt = 12;
                    break;
                case "K":
                    $rankInt = 13;
                    break;
                default:
                    $rankInt = null;
                    break;
            }
        }
        $this->rankInt = $rankInt;
    }

    public function getUnicodeChar(): string
    {
        return $this->unicodeChar;
    }

    public function getSuit($lowercase = true): string
    {
        return $lowercase ? strtolower($this->suit) : $this->suit;
    }

    public function getRank(): string
    {
        return $this->rank;
    }

    public function getRankInt(): int
    {
        return $this->rankInt;
    }
}
