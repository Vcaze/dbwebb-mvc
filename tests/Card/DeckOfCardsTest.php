<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;
use SebastianBergmann\Environment\Console;

/**
 * Test cases for class DeckOfCards.
 */
class DeckOfCardsTest extends TestCase
{
    /**
     * Construct object.
     */
    public function testCreateDeckOfCards()
    {
        // Creating a DeckOfCards object.
        $deck = new DeckOfCards();
        $this->assertInstanceOf("\App\Card\DeckOfCards", $deck);
    }

    /**
     * Test method getNumberCards() returning 52 cards right after creating DeckOfCards object.
     */
    public function testDeckOfCardsGetNumberCards()
    {
        $deck = new DeckOfCards();

        $res = $deck->getNumberCards();
        $this->assertEquals($res, 52);
    }

    /**
     * Method getCards().
     */
    public function testDeckOfCardsGetCards()
    {
        $deck = new DeckOfCards();
        $cards = $deck->getCards();

        foreach ($cards as $card) {
            $this->assertInstanceOf("\App\Card\Card", $card);
        }
    }

    /**
     * Method shuffle().
     */
    public function testDeckOfCardsShuffle()
    {
        srand(4005);

        $deck = new DeckOfCards();
        $deck->shuffle();

        $cards = $deck->getCards();
        // print($cards[0]->getUnicodeChar());
        // print($cards[1]->getUnicodeChar());
        $this->assertEquals("&#x1F0BD", $cards[0]->getUnicodeChar());
        $this->assertEquals("&#x1F0C1", $cards[1]->getUnicodeChar());
    }

    /**
     * Method sort().
     */
    public function testDeckOfCardsSort()
    {
        $deck = new DeckOfCards();

        $deck->shuffle();
        $deck->sort();
        $this->assertEquals($deck->getCards()[0]->getUnicodeChar(), "&#x1F0A1");
    }

    /**
     * Method draw().
     */
    public function testDeckOfCardsDraw()
    {
        $deck = new DeckOfCards();

        $card = $deck->draw()[0];
        $this->assertInstanceOf("\App\Card\Card", $card);
        $this->assertEquals(51, $deck->getNumberCards());
    }

    /**
     * Method reset().
     */
    public function testDeckOfCardsReset()
    {
        $deck = new DeckOfCards();

        $deck->draw(10);
        $deck->shuffle();
        $deck->reset();

        $this->assertEquals(52, $deck->getNumberCards());
        $this->assertEquals("&#x1F0A1", $deck->getCards()[0]->getUnicodeChar());
    }

    /**
     * Method reset().
     */
    public function testDeckOfCardsGetUnicodeChars()
    {
        $deck = new DeckOfCards();

        $deck->getCardsUnicodeChars();

        $this->assertEquals("&#x1F0A1", $deck->getCardsUnicodeChars()[0]);
    }


    /**
     * Method __toString().
     */
    public function testDeckOfCards__toString()
    {
        $deck = new DeckOfCards();

        $res = (string) $deck;

        $this->assertEquals("*DeckOfCards Object*", $res);
    }
}
