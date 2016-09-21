<?php
namespace SSE\Cards;

/**
 * Cards collection
 */
interface Cards extends \Iterator, \Countable
{
    // Iterator methods
	public function current() : Card;

    // Collection methods
	public function reverse() : Cards;
    public function slice(int $offset, int $length = null) : Cards;
    public function merge(Cards $other) : Cards;
    public function first() : Card;
    public function last() : Card;
    public function filter(callable $filter) : Cards;

    // Card specific methods
	public function turnAll() : Cards;
}
