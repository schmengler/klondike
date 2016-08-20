<?php
namespace SSE\Klondike\Field\Ds;


use SSE\Cards\Fake\FakePile;
use SSE\Klondike\Field\DiscardPile;

class DsStockTest extends \PHPUnit_Framework_TestCase
{
    public function testTurnCard()
    {
        $this->markTestIncomplete('needs CardsMove event implementation');
        
        $mockDiscardPile = $this->createMock(DiscardPile::class);
        $mockDiscardPile->expects($this->once())->method('receive');

        $pile = FakePile::fromUuids('stock-card-1', 'stock-card-2');
        $stock = new DsStock($pile);
        $stock->turnCard($mockDiscardPile);
    }
}
