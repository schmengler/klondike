<?php
namespace SSE\Cards;

final class CardSuit
{
	/**#@+
	 * Internal suit values. First bit determines color (red/black), second bit determines suit
	 */
	const HEARTS = 0b00;
	const DIAMONDS = 0b01;
	const SPADES = 0b10;
	const CLUBS = 0b11;
	/**#@-*/
	
	private $value;
	
	private function __construct(int $value)
	{
		$this->value = $value;
	}
	public function equals(CardSuit $other) : bool
	{
		return $this->value === $other->value;
	}
	public function colorEquals(CardSuit $other) : bool
	{
		return $this->value >> 1 === $other->value >> 1;
	}
	public function __toString() : string
	{
		return [
			self::HEARTS => '♥',
			self::DIAMONDS => '♦',
			self::SPADES => '♠',
			self::CLUBS => '♣',
		][$this->value];
	}
	public static function HEARTS() : CardSuit
	{
		return new self(self::HEARTS);
	}
	public static function SPADES() : CardSuit
	{
		return new self(self::SPADES);
	}
	public static function CLUBS() : CardSuit
	{
		return new self(self::CLUBS);
	}
	public static function DIAMONDS() : CardSuit
	{
		return new self(self::DIAMONDS);
	}
}