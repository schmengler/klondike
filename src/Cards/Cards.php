<?php
namespace SSE\Cards;

/**
 * Cards collection
 */
interface Cards extends \Iterator
{
	public function current() : Card;
	public function reverse() : Cards;
	public function turnAll() : Cards;
}