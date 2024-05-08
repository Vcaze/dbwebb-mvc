<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;
use SebastianBergmann\Environment\Console;

/**
 * Test cases for class TwentyOne.
 */
class TwentyOneTest extends TestCase
{
    /**
     * Construct object.
     */
    public function testCreateTwentyOne()
    {
        // Creating a TwentyOne object.
        $twentyOne = new TwentyOne();
        $this->assertInstanceOf("\App\Card\TwentyOne", $twentyOne);
    }

    /**
     * Method draw().
     */
    public function testTwentyOneDraw()
    {
        $twentyOne = new TwentyOne();

        $res = $twentyOne->draw(true, false)[0];
        $this->assertInstanceOf("\App\Card\Card", $res);
    }

    /**
     * Method scoreCard().
     */
    public function testTwentyOneScoreCardAndGetPlayerScore()
    {
        $twentyOne = new TwentyOne();

        $cards = $twentyOne->deck;
        foreach($cards as $card) {
            print(" " . $card->getRankInt() . $card->getSuit());
        }

        // Set seed
        srand(4005);

        // Draw a card twice
        $cards = $twentyOne->draw(true, false);
        $cards = $twentyOne->draw(true, false);

        $score = $twentyOne->getPlayerScore();
        $expectedScore = 12 + 6;
        $this->assertEquals($expectedScore, $score);
    }

    /**
     * Method getCardsDrawn().
     */
    public function testTwentyOneGetCardsDrawn()
    {
        $twentyOne = new TwentyOne();

        for ($i = 0; $i < 5; $i++) {
            $cards = $twentyOne->draw();
        }

        $res = $twentyOne->getCardsDrawn();

        $this->assertEquals($cards, $res);
    }

    /**
     * Method reset().
     */
    public function testTwentyOneReset()
    {
        $twentyOne = new TwentyOne();

        $twentyOne->draw(true);
        $twentyOne->draw(true);
        $twentyOne->reset();

        $res = $twentyOne->getPlayerScore();
        $this->assertEquals(0, $res);
    }

    /**
     * Method getStatus().
     */
    public function testTwentyOneGetStatus()
    {
        $twentyOne = new TwentyOne();

        $res = $twentyOne->getStatus();
        $this->assertEquals("play", $res);
    }


    /**
     * Method setStatus().
     */
    public function testTwentyOneSetStatus()
    {
        $twentyOne = new TwentyOne();

        $twentyOne->setStatus("finished");

        $res = $twentyOne->getStatus();
        $this->assertEquals("finished", $res);
    }

    /**
     * Method autoPlay().
     */
    public function testTwentyOneAutoPlay()
    {
        $twentyOne = new TwentyOne();

        $autoPlayData = $twentyOne->autoPlay();

        $res = $twentyOne->getStatus();
        $this->assertEquals("finished", $res);

        foreach ($autoPlayData as $roundData) {
            $score = $roundData['score'];
            $this->assertGreaterThanOrEqual(0, $score);
            $this->assertLessThanOrEqual(21, $score);
        }
    }

    /**
     * Method getBankScore().
     */
    public function testTwentyOneGetBankScore()
    {
        $twentyOne = new TwentyOne();

        $autoPlayData = $twentyOne->autoPlay();
        $bankScore = end($autoPlayData)['score'];

        $res = $twentyOne->getBankScore();
        $this->assertEquals($bankScore, $res);
    }
}
