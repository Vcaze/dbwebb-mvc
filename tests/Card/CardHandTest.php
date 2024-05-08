<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class CardHand.
 */
class CardHandTest extends TestCase
{
    /**
     * Construct object.
     */
    public function testCreateCardHand()
    {
        // Creating a CardHand object.
        $cardHand = new CardHand();
        $this->assertInstanceOf("\App\Card\CardHand", $cardHand);
    }

    /**
     * Adding cards with add() and get the get array of the card with getUnicodeChars().
     */
    public function testCardHandAdd()
    {
        $unicodeCharBase = "&#x1F0A";
        $suit = "Spades";

        $unicodeCharsExpected = [];

        // Creating a CardHand object.
        $cardHand = new CardHand();
        // Fill CardHand object with 2-6 of Spades.
        for ($i = 2; $i <= 6; $i++) {
            $unicode = $unicodeCharBase . $i;
            $card = new Card($unicode, $suit, (string) $i);
            $cardHand->add($card);
            $unicodeCharsExpected[] = $unicode;
        }

        $res = $cardHand->getUnicodeChars();
        $this->assertEquals($res, $unicodeCharsExpected);
    }

    /**
     * Adding cards with add() and get the get array of the card with getUnicodeChars().
     */
    public function testCardHandGetNumberCards()
    {
        $unicodeCharBase = "&#x1F0A";
        $suit = "Spades";

        // Creating a CardHand object.
        $cardHand = new CardHand();
        // Fill CardHand object with 2-6 of Spades, 5 cards.
        for ($i = 2; $i <= 6; $i++) {
            $unicode = $unicodeCharBase . $i;
            $card = new Card($unicode, $suit, (string) $i);
            $cardHand->add($card);
        }

        $res = $cardHand->getNumberCards();
        $this->assertEquals($res, 5);
    }
}
