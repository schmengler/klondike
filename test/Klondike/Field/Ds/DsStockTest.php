<?php
namespace SSE\Klondike\Field\Ds;


use SSE\Klondike\Field\TableauPile;
use SSE\Cards\Ds\DsMove;
use SSE\Cards\Fake\FakeCards;
use SSE\Cards\Fake\FakeEvent;
use SSE\Cards\Fake\FakePile;
use SSE\Cards\GameID;
use SSE\Cards\MoveOrigin;
use SSE\Klondike\Field\DiscardPile;
use SSE\Klondike\Field\FoundationPile;
use SSE\Klondike\Move\Command\MoveCards;

/**
 * @covers DsStock
 */
class DsStockTest extends \PHPUnit_Framework_TestCase
{
    private $discardPileMock;

    private $foundationPileMock;

    private $tableauPileMock;

    protected function setUp()
    {
        $this->discardPileMock = $this->createMock(DiscardPile::class);
        $this->foundationPileMock = $this->createMock(FoundationPile::class);
        $this->tableauPileMock = $this->createMock(TableauPile::class);

    }
    public function testPossibleMovesWithNonEmptyStock()
    {
        $this->discardPileMock->method('accepts')->willReturn(true);
        $this->foundationPileMock->expects($this->never())->method('accepts');
        $this->tableauPileMock->expects($this->never())->method('accepts');

        $stock = new DsStock(new GameID('game-1'), FakePile::fromUuids('possibly-a-card'));
        $commands = $stock->possibleMoves($this->discardPileMock, $this->foundationPileMock, $this->tableauPileMock);
        $this->assertCount(1, $commands);
        $this->assertInstanceOf(MoveCards::class, \iterator_to_array($commands)[0]);
    }
    public function testPossibleMovesWithEmptyStock()
    {
        $this->discardPileMock->method('accepts')->willReturn(true);
        $this->foundationPileMock->expects($this->never())->method('accepts');
        $this->tableauPileMock->expects($this->never())->method('accepts');

        $stock = new DsStock(new GameID('game-1'), FakePile::fromUuids());
        $commands = $stock->possibleMoves($this->discardPileMock, $this->foundationPileMock, $this->tableauPileMock);
        $this->assertCount(0, $commands);
    }
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
