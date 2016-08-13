<?php
namespace Klondike\Game;

interface DeckFactory
{
	public function create() : Deck;
}