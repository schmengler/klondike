<?php
namespace SSE\Cards;

/**
 * Cards collection
 */
interface Cards extends \Iterator
{
    // Iterator methods
	public function current() : Card;

    // Collection methods
	public function reverse() : Cards;
    public function slice(int $offset, int $length = null) : Cards;
    public function merge(Cards $other) : Cards;

    // Card specific methods
	public function turnAll() : Cards;
}
