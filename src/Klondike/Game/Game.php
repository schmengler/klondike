<?php
namespace SSE\Klondike\Game;

use SSE\Cards\Command;
use SSE\Cards\Deck;
use SSE\Cards\Game as GameInterface;
use SSE\Cards\GameID;
use SSE\Klondike\Field\DiscardPile;
use SSE\Klondike\Field\FoundationPile;
use SSE\Klondike\Field\Stock;
use SSE\Klondike\Field\TableauPile;

class Game implements GameInterface
{
    /**
     * @var GameID
     */
    private $id;
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
    /**
     * @var \DusanKasan\Knapsack\Collection
     */
    private $allPiles;

    public function __construct(GameID $gameId, Deck $startDeck)
    {
        $this->id = $gameId;
        $this->startDeck = $startDeck;
        $this->stock = new \SSE\Klondike\Field\Ds\DsStock(
            $gameId,
            new \SSE\Cards\Ds\DsPile(
                new \SSE\Cards\PileID(chr(27) . '[35mStack' . chr(27) . '[0m'),
                $startDeck->pile()->all()
            )
        );
        $this->discardPile = new \SSE\Klondike\Field\Ds\DsDiscardPile($gameId, \SSE\Cards\Ds\DsPile::fromSingleCards(new \SSE\Cards\PileID(chr(27) . '[36mDiscard Pile' . chr(27) . '[0m')));
        $this->foundation = \DusanKasan\Knapsack\Collection::range(1, 4)
            ->map(function($n) {
                return new \SSE\Klondike\Field\Ds\DsFoundationPile(
                    $this->id, \SSE\Cards\Ds\DsPile::fromSingleCards(new \SSE\Cards\PileID(chr(27).'[32mFoundation Pile ' . $n . chr(27) . '[0m'))
                );
            });
        $this->tableau = \DusanKasan\Knapsack\Collection::range(1, 7)
            ->map(
                function($n) {
                    return new \SSE\Klondike\Field\Ds\DsTableauPile(
                        $this->id, new \SSE\Cards\Ds\DsPile(new \SSE\Cards\PileID(chr(27).'[33mTableau Pile ' . $n . chr(27) . '[0m'), $this->stock->deal($n))
                    );
                }
            )->realize();

        $this->allPiles = \DusanKasan\Knapsack\Collection::from(
            [$this->stock, $this->discardPile]
        )->concat(
            $this->foundation, $this->tableau
        )->values(
        )->realize();

    }

    public function id(): GameID
    {
        return $this->id;
    }

    public function printPiles()
    {
        echo "Piles\n-----\n";
        $this->allPiles->each(
            function(\SSE\Cards\MoveOrigin $origin) {
                echo " - " . $origin->pileId() . "\t\t" . $origin . "\n";
            }
        )->realize();
    }

    public function printPossibleMoves()
    {
        echo "\n\nPossible Moves\n--------------\n";
        $targets = $this->allPiles->values()->toArray();
        $this->allPiles->map(
            function (\SSE\Cards\MoveOrigin $origin) use ($targets) {
                echo $origin->pileId() . "\n";
                return $origin->possibleMoves(...$targets);
            }
        )->flatten(
        )->values(
        )->each(
            function(Command $cmd, $index) {
                printf("%3d. %s\n", $index + 1, $cmd);
            }
        )->realize(
        );
    }

    public function chooseMove(int $moveId)
    {
        $targets = $this->allPiles->values()->toArray();
        $move = $this->allPiles->values(
        )->map(
            function (\SSE\Cards\MoveOrigin $origin) use ($targets) {
                return $origin->possibleMoves(...$targets);
            }
        )->flatten(
        )->values(
        )->get($moveId);
        $move();
    }

}