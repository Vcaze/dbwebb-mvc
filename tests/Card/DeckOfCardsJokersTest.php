<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;
use SebastianBergmann\Environment\Console;

/**
 * Test cases for class DeckOfCards.
 */
class DeckOfCardsJokersTest extends TestCase
{
    /**
     * Construct object.
     */
    public function testCreateDeckOfCardsJokers()
    {
        // Creating a DeckOfCardsJokers object.
        $deck = new DeckOfCardsJokers();
        $this->assertInstanceOf("\App\Card\DeckOfCardsJokers", $deck);
    }
}
