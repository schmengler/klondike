<?php
namespace SSE\Cards;

interface DeckFactory
{
	public function create() : Deck;
}