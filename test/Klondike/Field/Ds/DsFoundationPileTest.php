<?php
namespace SSE\Klondike\Field\Ds;


use SSE\Cards\Ds\DsMove;
use SSE\Cards\Fake\FakeCard;
use SSE\Cards\Fake\FakeCards;
use SSE\Cards\Fake\FakeCommands;
use SSE\Cards\Fake\FakeMoveOrigin;
use SSE\Cards\Fake\FakePile;
use SSE\Cards\GameID;
use SSE\Cards\PileID;
use SSE\Cards\PileWithValidation;
use SSE\Klondike\Move\Event\CardsMoved;

class DsFoundationPileTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var FakePile
     */
    private $internalPile;
    /**
     * @var GameID
     */
    private $gameId;
    /**
     * @var DsFoundationPile
     */
    private $foundationPile;

    protected function setUp()
    {
        $this->internalPile = new FakePile(
            new PileID('foundation-pile-1'),
            FakeCards::fromUuids('card-1', 'card-2', 'card-3', 'card-4')->turnAll()
        );
        $pile = new PileWithValidation(
            $this->internalPile
        );
        $this->gameId = new GameID('foundation-pile-game');
        $this->foundationPile= new DsFoundationPile($this->gameId, $pile);

    }
    public function testReceiveReturnsCardsMovedEvent()
    {
        $move = new DsMove(new FakeMoveOrigin(FakeCommands::fromNames()), FakeCards::fromUuids('move', 'it'));
        $event = $this->foundationPile->receive($move);
        $this->assertEquals(FakeCards::fromUuids('move', 'it'), $this->internalPile->transition()->top(2));
        $this->assertInstanceOf(CardsMoved::class, $event);
        //TODO assert payload
    }

    public function testMoveTopCardReturnsMoveWithTopCard()
    {
        $move = $this->foundationPile->moveTopCard();
        $actualCards = $move->cards();
        $this->assertCount(1, $actualCards);
        $this->assertEquals(FakeCard::fromUuid('card-4')->turnOver(), ...$actualCards);
    }
}
