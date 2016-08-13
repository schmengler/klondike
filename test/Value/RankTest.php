<?php
namespace Klondike\Value;

class RankTest extends \PHPUnit_Framework_TestCase
{
	public function testStringRepresentation()
	{
		$this->assertEquals('A', (string) new Rank(Rank::ACE));
		$this->assertEquals('2', (string) new Rank(2));
		$this->assertEquals('3', (string) new Rank(3));
		$this->assertEquals('4', (string) new Rank(4));
		$this->assertEquals('5', (string) new Rank(5));
		$this->assertEquals('6', (string) new Rank(6));
		$this->assertEquals('7', (string) new Rank(7));
		$this->assertEquals('8', (string) new Rank(8));
		$this->assertEquals('9', (string) new Rank(9));
		$this->assertEquals('10', (string) new Rank(10));
		$this->assertEquals('J', (string) new Rank(Rank::JACK));
		$this->assertEquals('Q', (string) new Rank(Rank::QUEEN));
		$this->assertEquals('K', (string) new Rank(Rank::KING));
	}
}