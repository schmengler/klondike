<?php
namespace SSE\Klondike\Game;

class Ds52CardsDeckFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $deckFactory = new Ds52CardsDeckFactory();
        $deck = $deckFactory->create();
        $this->assertEquals(52, $deck->size());
        $cards = $deck->pile()->all();
        //TODO assert card properties
    }
}