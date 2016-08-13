<?php
namespace Klondike\Move;

interface Commands extends \Iterator
{
	public function current() : Command;
}