<?php
namespace SSE\Klondike\Field\Ds;


use SSE\Cards\Ds\DsMove;
use SSE\Cards\Fake\FakeCards;
use SSE\Cards\Fake\FakePile;
use SSE\Cards\GameID;
use SSE\Cards\Move;
use SSE\Cards\MoveOrigin;
use SSE\Klondike\Field\DiscardPile;

/**
 * @covers DsStock
 */
class DsStockTest extends \PHPUnit_Framework_TestCase
{
    public function testAcceptMoveFromDiscardPile()
    {
        $stock = new DsStock(new GameID('game-1'), FakePile::fromUuids());
        $this->assertTrue(
            $stock->accepts(new DsMove($this->createMock(DiscardPile::class), FakeCards::fromUuids())), 'DiscardPile should be accepted'
        );
        $this->assertFalse(
            $stock->accepts(new DsMove($this->createMock(MoveOrigin::class), FakeCards::fromUuids())), 'Arbitrary MoveOrigin should not be accepted'
        );
    }
    public function testAcceptMoveOnlyIfEmpty()
    {
        $stock = new DsStock(new GameID('game-1'), FakePile::fromUuids('there', 'are', 'cards'));
        $this->assertFalse(
            $stock->accepts(new DsMove($this->createMock(DiscardPile::class), FakeCards::fromUuids())), 'DiscardPile should not be accepted if stock empty'
        );
    }
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
