<?php
namespace SSE\Klondike\Game;

use Klondike\Game\DiscardPile;
use Klondike\Game\FoundationPile;
use Klondike\Game\Stock;
use Klondike\Game\TableauPile;
use SSE\Cards\Deck;

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