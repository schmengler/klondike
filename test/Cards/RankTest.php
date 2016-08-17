<?php
namespace SSE\Cards;

class RankTest extends \PHPUnit_Framework_TestCase
{
	public function testStringRepresentation()
	{
		$this->assertEquals('A', (string) new CardRank(CardRank::ACE));
		$this->assertEquals('2', (string) new CardRank(2));
		$this->assertEquals('3', (string) new CardRank(3));
		$this->assertEquals('4', (string) new CardRank(4));
		$this->assertEquals('5', (string) new CardRank(5));
		$this->assertEquals('6', (string) new CardRank(6));
		$this->assertEquals('7', (string) new CardRank(7));
		$this->assertEquals('8', (string) new CardRank(8));
		$this->assertEquals('9', (string) new CardRank(9));
		$this->assertEquals('10', (string) new CardRank(10));
		$this->assertEquals('J', (string) new CardRank(CardRank::JACK));
		$this->assertEquals('Q', (string) new CardRank(CardRank::QUEEN));
		$this->assertEquals('K', (string) new CardRank(CardRank::KING));
	}
}