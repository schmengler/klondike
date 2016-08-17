<?php
namespace SSE\Cards;

/**
 * @covers CardSuit
 */
class CardSuitTest extends \PHPUnit_Framework_TestCase
{
	public function testEquality()
	{
		$this->assertTrue(CardSuit::hearts()->equals(CardSuit::hearts()));
		$this->assertTrue(CardSuit::spades()->equals(CardSuit::spades()));
		$this->assertTrue(CardSuit::clubs()->equals(CardSuit::clubs()));
		$this->assertTrue(CardSuit::diamonds()->equals(CardSuit::diamonds()));

		$this->assertFalse(CardSuit::hearts()->equals(CardSuit::spades()));
		$this->assertFalse(CardSuit::spades()->equals(CardSuit::clubs()));
		$this->assertFalse(CardSuit::clubs()->equals(CardSuit::diamonds()));
		$this->assertFalse(CardSuit::diamonds()->equals(CardSuit::hearts()));
	}
	public function testColorEquality()
	{
		$this->assertTrue(CardSuit::hearts()->colorEquals(CardSuit::hearts()));
		$this->assertTrue(CardSuit::hearts()->colorEquals(CardSuit::diamonds()));
		$this->assertTrue(CardSuit::diamonds()->colorEquals(CardSuit::hearts()));
		$this->assertTrue(CardSuit::diamonds()->colorEquals(CardSuit::diamonds()));
		$this->assertTrue(CardSuit::spades()->colorEquals(CardSuit::spades()));
		$this->assertTrue(CardSuit::spades()->colorEquals(CardSuit::clubs()));
		$this->assertTrue(CardSuit::clubs()->colorEquals(CardSuit::clubs()));
		$this->assertTrue(CardSuit::clubs()->colorEquals(CardSuit::spades()));

		$this->assertFalse(CardSuit::hearts()->colorEquals(CardSuit::spades()));
		$this->assertFalse(CardSuit::hearts()->colorEquals(CardSuit::clubs()));
		$this->assertFalse(CardSuit::diamonds()->colorEquals(CardSuit::spades()));
		$this->assertFalse(CardSuit::diamonds()->colorEquals(CardSuit::clubs()));
		$this->assertFalse(CardSuit::spades()->colorEquals(CardSuit::hearts()));
		$this->assertFalse(CardSuit::spades()->colorEquals(CardSuit::diamonds()));
		$this->assertFalse(CardSuit::clubs()->colorEquals(CardSuit::hearts()));
		$this->assertFalse(CardSuit::clubs()->colorEquals(CardSuit::diamonds()));
	}
	public function testUtf8Representation()
	{
		$this->assertEquals('♥', (string) CardSuit::hearts());
		$this->assertEquals('♦', (string) CardSuit::diamonds());
		$this->assertEquals('♠', (string) CardSuit::spades());
		$this->assertEquals('♣', (string) CardSuit::clubs());
	}
}