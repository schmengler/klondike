<?php
namespace SSE\Klondike\Field\Ds;


use SSE\Cards\Fake\FakeCommands;
use SSE\Cards\Fake\FakeMoveOrigin;
use SSE\Cards\PileID;
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
use SSE\Klondike\Move\Event\PileTurnedOver;

/**
 * @covers DsStock
 */
class DsStockTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DiscardPile|\PHPUnit_Framework_MockObject_MockObject
     */
    private $discardPileMock;
    /**
     * @var FoundationPile|\PHPUnit_Framework_MockObject_MockObject
     */
    private $foundationPileMock;
    /**
     * @var TableauPile|\PHPUnit_Framework_MockObject_MockObject
     */
    private $tableauPileMock;

    protected function setUp()
    {
        $this->discardPileMock = $this->createMock(DiscardPile::class);
        $this->foundationPileMock = $this->createMock(FoundationPile::class);
        $this->tableauPileMock = $this->createMock(TableauPile::class);

    }
    public function testDeal()
    {
        $internalPile = FakePile::fromUuids('c-1', 'c-2', 'c-3');
        $stock = new DsStock(new GameID('new-game'), $internalPile);
        $dealtCards = $stock->deal(2);
        $this->assertEquals(
            FakePile::fromUuids('c-1'),
            $internalPile->transition()
        );
        $this->assertEquals(
            FakePile::fromUuids('c-2', 'c-3')->all(),
            $dealtCards
        );
    }
    public function testPossibleMovesWithNonEmptyStock()
    {
        $this->discardPileMock->method('accepts')->willReturn(true);
        $this->discardPileMock->method('pileId')->willReturn(new PileID('d'));
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
    public function testReceiveReturnsPileTurnedOverEvent()
    {
        $stockPile = FakePile::fromUuids();
        $stock = new DsStock(new GameID('game-1'), $stockPile);
        $move = new DsMove(new FakeMoveOrigin(FakeCommands::fromNames()), FakeCards::fromUuids('x', 'y'));
        $event = $stock->receive($move);
        $this->assertInstanceOf(PileTurnedOver::class, $event);
        $this->assertEquals(FakeCards::fromUuids('x', 'y'), $stockPile->transition()->all());
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
