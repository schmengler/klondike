<?php
namespace SSE\Cards;

interface Commands extends \Iterator
{
	public function current() : Command;
}