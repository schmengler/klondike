<?php
namespace Klondike\Value;

class SuitTest extends \PHPUnit_Framework_TestCase
{
	public function testEquality()
	{
		$this->assertTrue(Suit::HEARTS()->equals(Suit::HEARTS()));
		$this->assertTrue(Suit::SPADES()->equals(Suit::SPADES()));
		$this->assertTrue(Suit::CLUBS()->equals(Suit::CLUBS()));
		$this->assertTrue(Suit::DIAMONDS()->equals(Suit::DIAMONDS()));

		$this->assertFalse(Suit::HEARTS()->equals(Suit::SPADES()));
		$this->assertFalse(Suit::SPADES()->equals(Suit::CLUBS()));
		$this->assertFalse(Suit::CLUBS()->equals(Suit::DIAMONDS()));
		$this->assertFalse(Suit::DIAMONDS()->equals(Suit::HEARTS()));
	}
	public function testColorEquality()
	{
		$this->assertTrue(Suit::HEARTS()->colorEquals(Suit::HEARTS()));
		$this->assertTrue(Suit::HEARTS()->colorEquals(Suit::DIAMONDS()));
		$this->assertTrue(Suit::DIAMONDS()->colorEquals(Suit::HEARTS()));
		$this->assertTrue(Suit::DIAMONDS()->colorEquals(Suit::DIAMONDS()));
		$this->assertTrue(Suit::SPADES()->colorEquals(Suit::SPADES()));
		$this->assertTrue(Suit::SPADES()->colorEquals(Suit::CLUBS()));
		$this->assertTrue(Suit::CLUBS()->colorEquals(Suit::CLUBS()));
		$this->assertTrue(Suit::CLUBS()->colorEquals(Suit::SPADES()));

		$this->assertFalse(Suit::HEARTS()->colorEquals(Suit::SPADES()));
		$this->assertFalse(Suit::HEARTS()->colorEquals(Suit::CLUBS()));
		$this->assertFalse(Suit::DIAMONDS()->colorEquals(Suit::SPADES()));
		$this->assertFalse(Suit::DIAMONDS()->colorEquals(Suit::CLUBS()));
		$this->assertFalse(Suit::SPADES()->colorEquals(Suit::HEARTS()));
		$this->assertFalse(Suit::SPADES()->colorEquals(Suit::DIAMONDS()));
		$this->assertFalse(Suit::CLUBS()->colorEquals(Suit::HEARTS()));
		$this->assertFalse(Suit::CLUBS()->colorEquals(Suit::DIAMONDS()));
	}
	public function testUtf8Representation()
	{
		$this->assertEquals('♥', (string) Suit::HEARTS());
		$this->assertEquals('♦', (string) Suit::DIAMONDS());
		$this->assertEquals('♠', (string) Suit::SPADES());
		$this->assertEquals('♣', (string) Suit::CLUBS());
	}
}