<?php
namespace SSE\Cards;

interface Command
{
	public function __invoke() : Event;
	public function __toString() : string;
}