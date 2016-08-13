<?php
namespace Klondike\Game;

class Game
{
	/**
	 * @var Deck
	 */
	private $startDeck;
	/**
	 * @var Stock
	 */
	private $stock;
	/**
	 * @var DiscardPile
	 */
	private $discardPile;
	/**
	 * @var TableauPile[]
	 */
	private $tableau;
	/**
	 * @var FoundationPile[]
	 */
	private $foundation;
}