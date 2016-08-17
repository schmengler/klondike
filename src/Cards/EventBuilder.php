<?php
namespace SSE\Cards;

interface EventBuilder
{
	public function create() : Event;
}