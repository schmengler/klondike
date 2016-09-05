<?php
namespace SSE\Klondike\Field\Ds;

use SSE\Cards\Ds\DsMove;
use SSE\Cards\Fake\FakeCard;
use SSE\Cards\Fake\FakeCards;
use SSE\Cards\Fake\FakeCommands;
use SSE\Cards\Fake\FakeEvent;
use SSE\Cards\Fake\FakeMoveOrigin;
use SSE\Cards\Fake\FakePile;
use SSE\Cards\GameID;
use SSE\Cards\InvalidMove;
use SSE\Cards\MoveOrigin;
use SSE\Cards\MoveTarget;
use SSE\Cards\MoveWithCallbacks;
use SSE\Cards\Pile;
use SSE\Cards\PileID;
use SSE\Cards\PileWithValidation;
use SSE\Klondike\Field\FoundationPile;
use SSE\Klondike\Field\Stock;
use SSE\Klondike\Field\TableauPile;
use SSE\Klondike\Move\Event\CardsMoved;
use SSE\Klondike\Move\Command\TurnOverPile;

/**
 * @covers DsDiscardPile
 * @covers DsStock
 */
class DsDiscardPileTest extends \PHPUnit_Framework_TestCase
{
    private $foundationPileMock;
    private $stockMock;
    private $tableauPileMock;
    /**
     * @var FakePile
     */
    private $internalPile;
    /**
     * @var DsDiscardPile
     */
    private $discardPile;
    /**
     * @var MoveTarget|\PHPUnit_Framework_MockObject_MockObject
     */
    private $targetMock;
    /**
     * @var GameID
     */
    private $gameId;

    protected function setUp()
    {
        $this->tableauPileMock = $this->createMock(TableauPile::class);
        $this->foundationPileMock = $this->createMock(FoundationPile::class);
        $this->stockMock = $this->createMock(Stock::class);
        $this->targetMock = $this->createMock(MoveTarget::class);
        $this->internalPile = new FakePile(
            new PileID('discard-pile'),
            FakeCards::fromUuids('card-1', 'card-2', 'card-3', 'card-4')->turnAll()
        );
        $pile = new PileWithValidation(
            $this->internalPile
        );
        $this->gameId = new GameID('discard-pile-game');
        $this->discardPile = new DsDiscardPile($this->gameId, $pile);
    }
    public function testPossibleMovesWithEmptyStock()
    {
        $this->stockMock->method('accepts')->willReturn(true);
        $this->foundationPileMock->expects($this->never())->method('accepts');
        $this->tableauPileMock->expects($this->never())->method('accepts');

        $commands = $this->discardPile->possibleMoves($this->foundationPileMock, $this->tableauPileMock, $this->stockMock);
        $this->assertCount(1, $commands);
        $this->assertInstanceOf(TurnOverPile::class, \iterator_to_array($commands)[0]);
    }
    public function testPossibleMovesWithNonEmptyStock()
    {
        $this->stockMock->method('accepts')->willReturn(false);
        $this->foundationPileMock->expects($this->never())->method('accepts');
        $this->tableauPileMock->expects($this->never())->method('accepts');

        $commands = $this->discardPile->possibleMoves($this->foundationPileMock, $this->tableauPileMock, $this->stockMock);
        $this->assertCount(0, $commands);
    }
    public function testMoveTopCardReturnsMoveWithTopCard()
    {
        $move = $this->discardPile->moveTopCard();
        $actualCards = $move->cards();
        $this->assertCount(1, $actualCards);
        $this->assertEquals(FakeCard::fromUuid('card-4')->turnOver(), ...$actualCards);
    }
    public function testIncompleteMoveLocksPile()
    {
        $this->targetMock->method('receive')->willReturn(FakeEvent::emptyEvent());
        $move = $this->discardPile->moveTopCard();
        $this->assertInstanceOf(MoveWithCallbacks::class, $move);
        $this->setExpectedExceptionRegExp(InvalidMove::class);
        $this->discardPile->moveTopCard();
    }
    public function testCompleteMoveUnlocksPile()
    {
        $this->targetMock->method('receive')->willReturn(FakeEvent::emptyEvent());
        $move = $this->discardPile->moveTopCard();
        $this->assertInstanceOf(MoveWithCallbacks::class, $move);
        $move->to($this->targetMock);
        $this->discardPile->moveTopCard();
    }
    public function testCanceledMoveUnlocksPile()
    {
        $this->targetMock->method('receive')->willThrowException(new InvalidMove());
        $rethrown = false;

        $move = $this->discardPile->moveTopCard();
        $this->assertInstanceOf(MoveWithCallbacks::class, $move);
        try {
            $move->to($this->targetMock);
        } catch (InvalidMove $e) {
            $rethrown = true;
        }
        $this->assertTrue($rethrown, 'Exception that canceled move should be rethrown');
        $this->discardPile->moveTopCard();
    }
    public function testCompleteMoveDropsCard()
    {
        $this->mockInternalPile()->expects($this->once())->method('drop')->with(1);
        $this->targetMock->method('receive')->willReturn(FakeEvent::emptyEvent());
        $move = $this->discardPile->moveTopCard();
        $this->assertInstanceOf(MoveWithCallbacks::class, $move);
        $move->to($this->targetMock);
    }
    public function testCanceledMoveDoesNotDropCard()
    {
        $this->mockInternalPile()->expects($this->never())->method('drop');
        $this->targetMock->method('receive')->willThrowException(new InvalidMove());
        $move = $this->discardPile->moveTopCard();
        $this->assertInstanceOf(MoveWithCallbacks::class, $move);
        try {
            $move->to($this->targetMock);
        } catch (InvalidMove $e) {
            // expected
        }
    }
    public function testTurnOverAsStock()
    {
        $stockPile = FakePile::fromUuids(...[]);
        $stock = new DsStock($this->gameId, $stockPile);
        $this->discardPile->turnOver($stock);
        $this->assertEquals(FakeCards::fromUuids(), $this->internalPile->transition()->all(), 'Discard pile should be empty');
        $this->assertEquals(FakeCards::fromUuids('card-4', 'card-3', 'card-2', 'card-1'), $stockPile->transition()->all(), 'Stock pile should be reversed and turned discard pile');
    }

    public function testAcceptMoveFromStock()
    {
        $this->assertTrue(
            $this->discardPile->accepts(new DsMove($this->createMock(Stock::class), FakeCards::fromUuids())), 'Stock should be accepted'
        );
        $this->assertFalse(
            $this->discardPile->accepts(new DsMove($this->createMock(MoveOrigin::class), FakeCards::fromUuids())), 'Arbitrary MoveOrigin should not be accepted'
        );
    }
    public function testReceiveReturnsCardsMovedEvent()
    {
        $move = new DsMove(new FakeMoveOrigin(FakeCommands::fromNames()), FakeCards::fromUuids());
        $event = $this->discardPile->receive($move);
        $this->assertInstanceOf(CardsMoved::class, $event);
        //TODO assert payload
    }
    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|Pile
     */
    private function mockInternalPile() : \PHPUnit_Framework_MockObject_MockObject
    {
        $pile = $this->createMock(Pile::class);
        $this->discardPile = new DsDiscardPile($this->gameId, $pile);
        return $pile;
    }
}
