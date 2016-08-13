<?php
namespace Klondike\Move;

interface Command
{
	public function __invoke() : Event;
	public function __toString() : string;
}