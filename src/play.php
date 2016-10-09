<?php
require __DIR__ . '/../vendor/autoload.php';

$gameId = new \SSE\Cards\GameID('test-game');

$stock = new \SSE\Klondike\Field\Ds\DsStock(
    $gameId,
    new \SSE\Cards\Ds\DsPile(new \SSE\Cards\PileID('Stack'), (new \SSE\Cards\ShuffleDeck(
        (new \SSE\Klondike\Game\Ds52CardsDeckFactory())->create())
    )->shuffle()->pile()->all())
);

$discardPile = new \SSE\Klondike\Field\Ds\DsDiscardPile($gameId, \SSE\Cards\Ds\DsPile::fromSingleCards(new \SSE\Cards\PileID('Discard Pile')));
$foundationPiles = \DusanKasan\Knapsack\Collection::range(1, 4)
    ->map(function($n) use ($gameId) {
        return new \SSE\Klondike\Field\Ds\DsFoundationPile(
            $gameId, \SSE\Cards\Ds\DsPile::fromSingleCards(new \SSE\Cards\PileID('Foundation Pile ' . $n))
        );
    });
$tableauPiles = \DusanKasan\Knapsack\Collection::range(1, 7)
    ->map(
        function($n) use ($gameId, $stock) {
            return new \SSE\Klondike\Field\Ds\DsTableauPile(
                $gameId, new \SSE\Cards\Ds\DsPile(new \SSE\Cards\PileID('Tableau Pile ' . $n), $stock->deal($n))
            );
        }
    )->realize();

$allPiles = \DusanKasan\Knapsack\Collection::from([$stock, $discardPile])->concat($foundationPiles, $tableauPiles)->values()->realize();

//TODO implement initialization in Game class

echo "KLONDIKE\n";

while(true):

echo "Piles\n-----\n";
$allPiles->each(
    function(\SSE\Cards\MoveOrigin $origin) {
        echo " - " . $origin->pileId() . "\t\t" . $origin . "\n";
    }
)->realize();

//TODO write printers for piles

echo "\n\nPossible Moves\n--------------\n";
/** @var \DusanKasan\Knapsack\Collection $allPiles */
$targets = $allPiles->values()->toArray();
$moves = [];
$allPiles->values(
)->map(
    function(\SSE\Cards\MoveOrigin $origin) use ($targets) {
//        echo $origin->pileId() . "\n";
        return $origin->possibleMoves(...$targets);
    }
)->each(
    function(\SSE\Cards\Commands $commands) use (&$moves) {
        foreach ($commands as $cmd) {
            $index = \count($moves);
            $moves[$index] = $cmd;
            echo  ($index + 1) . ". " . $cmd . "\n";
        }
    }
)->realize(
);

$moveId = trim(fgets(STDIN)) - 1;
if (isset($moves[$moveId])) {
    $moves[$moveId]();
}

endwhile;
echo "---";
