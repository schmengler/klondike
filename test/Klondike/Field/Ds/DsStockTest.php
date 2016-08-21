<?php
namespace SSE\Klondike\Field\Ds;


use SSE\Cards\Ds\DsMove;
use SSE\Cards\Event;
use SSE\Cards\Fake\FakeCards;
use SSE\Cards\Fake\FakeEvent;
use SSE\Cards\Fake\FakePile;
use SSE\Cards\GameID;
use SSE\Cards\Move;
use SSE\Cards\MoveOrigin;
use SSE\Cards\PileID;
use SSE\Klondike\Field\DiscardPile;
use SSE\Klondike\Move\Event\CardsMoved;

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
        $mockDiscardPile = $this->createMock(DiscardPile::class);
        $cardsMovedEvent = FakeEvent::emptyEvent();
        $mockDiscardPile->expects($this->once())
            ->method('receive')
            ->willReturn($cardsMovedEvent);

        $pile = FakePile::fromUuids('stock-card-1', 'stock-card-2');
        $stock = new DsStock(new GameID('game-1'), $pile);

        $this->assertSame($cardsMovedEvent, $stock->turnCard($mockDiscardPile));
        //TODO use less mocks and assert event payload?
    }
}
