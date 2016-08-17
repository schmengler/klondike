<?php
namespace SSE\Cards;

class SuitTest extends \PHPUnit_Framework_TestCase
{
	public function testEquality()
	{
		$this->assertTrue(CardSuit::HEARTS()->equals(CardSuit::HEARTS()));
		$this->assertTrue(CardSuit::SPADES()->equals(CardSuit::SPADES()));
		$this->assertTrue(CardSuit::CLUBS()->equals(CardSuit::CLUBS()));
		$this->assertTrue(CardSuit::DIAMONDS()->equals(CardSuit::DIAMONDS()));

		$this->assertFalse(CardSuit::HEARTS()->equals(CardSuit::SPADES()));
		$this->assertFalse(CardSuit::SPADES()->equals(CardSuit::CLUBS()));
		$this->assertFalse(CardSuit::CLUBS()->equals(CardSuit::DIAMONDS()));
		$this->assertFalse(CardSuit::DIAMONDS()->equals(CardSuit::HEARTS()));
	}
	public function testColorEquality()
	{
		$this->assertTrue(CardSuit::HEARTS()->colorEquals(CardSuit::HEARTS()));
		$this->assertTrue(CardSuit::HEARTS()->colorEquals(CardSuit::DIAMONDS()));
		$this->assertTrue(CardSuit::DIAMONDS()->colorEquals(CardSuit::HEARTS()));
		$this->assertTrue(CardSuit::DIAMONDS()->colorEquals(CardSuit::DIAMONDS()));
		$this->assertTrue(CardSuit::SPADES()->colorEquals(CardSuit::SPADES()));
		$this->assertTrue(CardSuit::SPADES()->colorEquals(CardSuit::CLUBS()));
		$this->assertTrue(CardSuit::CLUBS()->colorEquals(CardSuit::CLUBS()));
		$this->assertTrue(CardSuit::CLUBS()->colorEquals(CardSuit::SPADES()));

		$this->assertFalse(CardSuit::HEARTS()->colorEquals(CardSuit::SPADES()));
		$this->assertFalse(CardSuit::HEARTS()->colorEquals(CardSuit::CLUBS()));
		$this->assertFalse(CardSuit::DIAMONDS()->colorEquals(CardSuit::SPADES()));
		$this->assertFalse(CardSuit::DIAMONDS()->colorEquals(CardSuit::CLUBS()));
		$this->assertFalse(CardSuit::SPADES()->colorEquals(CardSuit::HEARTS()));
		$this->assertFalse(CardSuit::SPADES()->colorEquals(CardSuit::DIAMONDS()));
		$this->assertFalse(CardSuit::CLUBS()->colorEquals(CardSuit::HEARTS()));
		$this->assertFalse(CardSuit::CLUBS()->colorEquals(CardSuit::DIAMONDS()));
	}
	public function testUtf8Representation()
	{
		$this->assertEquals('♥', (string) CardSuit::HEARTS());
		$this->assertEquals('♦', (string) CardSuit::DIAMONDS());
		$this->assertEquals('♠', (string) CardSuit::SPADES());
		$this->assertEquals('♣', (string) CardSuit::CLUBS());
	}
}