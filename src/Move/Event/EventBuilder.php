<?php
namespace Klondike\Move\Event;

use Klondike\Move\Event;

interface EventBuilder
{
	public function create() : Event;
}