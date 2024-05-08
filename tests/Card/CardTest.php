<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Card.
 */
class CardTest extends TestCase
{
    /**
     * Construct object and verify that properties has been set correct and their
     * respective get methods returns them.
     */
    public function testCreateCard()
    {
        $unicodeChar = "&#x1F0AD";
        $suit = "Spades";
        $rank = "Q";

        // Creating a Card object, Queen of Spades.
        $card = new Card($unicodeChar, $suit, $rank);
        $this->assertInstanceOf("\App\Card\Card", $card);
    }

    /**
     * Creating Card object for 4 of Diamonds.
     */
    public function testCreateCardExtraOne()
    {
        $unicodeChar = "&#x1F0C4";
        $suit = "Diamonds";
        $rank = "4";

        // Creating a Card object, 4 of Diamonds.
        $card = new Card($unicodeChar, $suit, $rank);

        $res = $card->getSuit();
        $this->assertEquals($res, "diamonds");

        $res = $card->getRankInt();
        $this->assertEquals($res, 4);
    }

    /**
     * Creating Card object for King of Hearts.
     */
    public function testCreateCardExtraTwo()
    {
        $unicodeChar = "&#x1F0BE";
        $suit = "Hearts";
        $rank = "K";

        // Creating a Card object, King of Hearts.
        $card = new Card($unicodeChar, $suit, $rank);

        $res = $card->getSuit();
        $this->assertEquals($res, "hearts");

        $res = $card->getRankInt();
        $this->assertEquals($res, 13);
    }

    /**
     * Construct object and verify that properties has been set correct and their
     * respective get methods returns them.
     */
    public function testCardProperties()
    {
        $unicodeChar = "&#x1F0AD";
        $suit = "Spades";
        $rank = "Q";

        // Creating a Card object, Queen of Spades.
        $card = new Card($unicodeChar, $suit, $rank);

        $res = $card->getUnicodeChar();
        $this->assertEquals($res, $unicodeChar);

        $res = $card->getSuit(false);
        $this->assertEquals($res, $suit);

        $res = $card->getRank();
        $this->assertEquals($res, $rank);
    }


    /**
     * Test that $rankInt has been set correct and is returned from getRankInt().
     */
    public function testCardGetRankInt()
    {
        $card = new Card("&#x1F0AD", "Spades", "Q");
        
        $res = $card->getRankInt();
        $this->assertEquals($res, 12);
    }
}
