<?php
namespace SSE\Cards;

interface Commands extends \Iterator, \Countable
{
	public function current() : Command;
}