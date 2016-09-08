<?php
namespace SSE\Cards;

final class CardRank
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

    public static function ace() : CardRank
    {
        return new self(self::ACE);
    }

    public static function jack() : CardRank
    {
        return new self(self::JACK);
    }

    public static function queen() : CardRank
    {
        return new self(self::QUEEN);
    }

    public static function king() : CardRank
    {
        return new self(self::KING);
    }

    public static function number($number) : CardRank
    {
        return new self($number);
    }

    public function equals(CardRank $other) : bool
	{
		return $this->value === $other->value;
	}
	public function difference(CardRank $other) : int
    {
        return $this->value - $other->value;
    }
	public function __toString() : string
	{
		return "".([
			self::ACE => 'A',
			self::JACK => 'J',
			self::QUEEN => 'Q',
			self::KING => 'K',
		][$this->value] ?? $this->value);
	}
}