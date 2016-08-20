<?php
namespace SSE\Klondike\Field\Ds;

use SSE\Cards\Fake\FakeCard;
use SSE\Cards\Fake\FakeCards;
use SSE\Cards\Fake\FakeEvent;
use SSE\Cards\Fake\FakePile;
use SSE\Cards\GameID;
use SSE\Cards\InvalidMove;
use SSE\Cards\MoveTarget;
use SSE\Cards\MoveWithCallbacks;
use SSE\Cards\Pile;
use SSE\Cards\PileID;
use SSE\Cards\PileWithValidation;

/**
 * @covers DsDiscardPile
 * @covers DsStock
 */
class DsDiscardPileTest extends \PHPUnit_Framework_TestCase
{
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