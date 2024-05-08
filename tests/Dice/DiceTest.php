<?php

namespace App\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class DiceTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateDice()
    {
        $die = new Dice();
        $this->assertInstanceOf("\App\Dice\Dice", $die);

        $res = $die->getAsString();
        $this->assertNotEmpty($res);
    }

    public function testDiceRoll()
    {
        $die = new Dice();
        
        $res = $die->roll();
        $this->assertGreaterThanOrEqual(1, $res);
        $this->assertLessThanOrEqual(6, $res);
    }

    public function testDiceGetValue()
    {
        $die = new Dice();
        
        $expected = $die->roll();
        $res = $die->getValue();
        $this->assertEquals($expected, $res);
    }
}
