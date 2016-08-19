<?php
namespace SSE\Klondike\Game;

use DusanKasan\Knapsack\Collection;
use SSE\Cards\Card;
use SSE\Cards\CardVisibility;

class Ds52CardsDeckFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $deckFactory = new Ds52CardsDeckFactory();
        $deck = $deckFactory->create();
        $this->assertEquals(52, $deck->size(), 'Deck size should be 52');
        $actualCards = Collection::from($deck->pile()->all());
        $actualCards->each(function(Card $card) {
            $this->assertEquals(CardVisibility::faceDown(), $card->visibility(), 'All cards should be face down');
        })->realize();
        $this->assertEquals(52, $actualCards
            ->map(function(Card $card){
                return $card->value();
            })->distinct()->size(), 'All cards should have different values');
        $this->assertEquals(52, $actualCards
            ->map(function(Card $card){
                return $card->id();
            })->distinct()->size(), 'All cards should have different ids');
    }
}