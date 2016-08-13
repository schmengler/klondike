<?php
namespace Klondike\Value;

final class Rank
{
	/**#@+
	 * Internal rank values. Use as constructor parameters
	 */
	const ACE = 1;
	const JACK = 11;
	const QUEEN = 12;
	const KING = 13;
	/**#@-*/
	
	private $value;
	
	public function __construct(int $rank)
	{
		$this->value = $rank;
	}
	public function equals(Suit $other)
	{
		return $this->value === $other->value;
	}
	public function __toString() : string
	{
		return [
			self::ACE => 'A',
			self::JACK => 'J',
			self::QUEEN => 'Q',
			self::KING => 'K',
		][$this->value] ?? $this->value;
	}
}