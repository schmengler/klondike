<?php
require __DIR__ . '/../vendor/autoload.php';

$game = new \SSE\Klondike\Game\Game(
    new \SSE\Cards\GameID('test-game'),
    (
        new \SSE\Cards\ShuffleDeck(
            (new \SSE\Klondike\Game\Ds52CardsDeckFactory())->create()
        )
    )->shuffle()
);

echo "KLONDIKE\n";

while(true):

    $game->printPiles();
    $game->printPossibleMoves();
    echo "> ";
    $moveId = trim(fgets(STDIN)) - 1;
    try {
        $game->chooseMove($moveId);
    } catch (\DusanKasan\Knapsack\Exceptions\ItemNotFound $e) {
        echo chr(27)."[31mInvalid move\n" . chr(27) . "[0m";
    }
    echo "\n";
//TODO win condition
endwhile;
echo "---";
