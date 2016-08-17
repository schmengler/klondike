<?php
namespace SSE\Cards;

/**
 * @covers SSE\Cards\CardValue
 */
class CardValueTest extends \PHPUnit_Framework_TestCase
{
    public function testValues()
    {
        $value = new CardValue(CardRank::queen(), CardSuit::hearts());
        $this->assertEquals(CardRank::queen(), $value->rank());
        $this->assertEquals(CardSuit::hearts(), $value->suit());
    }
}