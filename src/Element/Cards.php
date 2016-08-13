<?php
namespace Klondike\Element;

interface Cards extends \Iterator
{
	public function current() : Card;
}