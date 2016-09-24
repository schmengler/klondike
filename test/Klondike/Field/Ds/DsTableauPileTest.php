<?php
namespace SSE\Klondike\Field\Ds;


use DusanKasan\Knapsack\Collection;
use SSE\Cards\CardID;
use SSE\Cards\CardRank;
use SSE\Cards\Cards;
use SSE\Cards\CardSuit;
use SSE\Cards\CardValue;
use SSE\Cards\CardVisibility;
use SSE\Cards\Ds\DsCard;
use SSE\Cards\Ds\DsCards;
use SSE\Cards\Ds\DsMove;
use SSE\Cards\Ds\DsPile;
use SSE\Cards\Fake\FakeCard;
use SSE\Cards\Fake\FakeCards;
use SSE\Cards\Fake\FakeCommands;
use SSE\Cards\Fake\FakeMoveOrigin;
use SSE\Cards\Fake\FakePile;
use SSE\Cards\GameID;
use SSE\Cards\Move;
use SSE\Cards\PileID;
use SSE\Cards\PileWithValidation;
use SSE\Klondike\Field\FoundationPile;
use SSE\Klondike\Field\TableauPile;
use SSE\Klondike\Move\Command\MoveCards;
use SSE\Klondike\Move\Command\TurnCard;
use SSE\Klondike\Move\Event\CardsMoved;

class DsTableauPileTest extends \PHPUnit_Framework_TestCase
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
     * @var DsTableauPile
     */
    private $tableauPile;

    protected function setUp()
    {
        $this->internalPile = new FakePile(
            new PileID('tableau-pile-1'),
            FakeCards::fromUuids('card-1', 'card-2', 'card-3', 'card-4')->turnAll()
        );
        $pile = new PileWithValidation(
            $this->internalPile
        );
        $this->gameId = new GameID('tableau-pile-game');
        $this->tableauPile= new DsTableauPile($this->gameId, $pile);

    }
    public function testReceiveReturnsCardsMovedEvent()
    {
        $move = new DsMove(new FakeMoveOrigin(FakeCommands::fromNames()), FakeCards::fromUuids('move', 'it'));
        $event = $this->tableauPile->receive($move);
        $this->assertEquals(FakeCards::fromUuids('move', 'it'), $this->internalPile->transition()->top(2));
        $this->assertInstanceOf(CardsMoved::class, $event);
        //TODO assert payload
    }

    public function testMoveCardsReturnsMoveWithSelectedCards()
    {
        $move = $this->tableauPile->moveCards(2);
        $actualCards = $move->cards();
        $this->assertCount(2, $actualCards);
        $this->assertEquals(
            \iterator_to_array(FakeCards::fromUuids('card-3', 'card-4')->turnAll()),
            \iterator_to_array($actualCards)
        );
    }

    /**
     * @dataProvider dataAcceptedMoves
     */
    public function testAcceptRules(DsCards $cardsOnPile, string $originClass, DsCards $movedCards, bool $shouldAccept)
    {
        $this->tableauPile = new DsTableauPile(
            $this->gameId,
            new PileWithValidation(
                new DsPile(
                    new PileID('tableau-pile-2'),
                    $cardsOnPile
                )
            )
        );
        $this->assertEquals(
            $shouldAccept,
            $this->tableauPile->accepts(new DsMove(
                $this->createMock($originClass),
                $movedCards
            ))
        );
    }
    public static function dataAcceptedMoves()
    {
        $queenOfHeartsOnTop = DsCards::fromCards(
            new DsCard(new CardID('ks'), new CardValue(CardRank::king(), CardSuit::spades()), CardVisibility::faceUp()),
            new DsCard(new CardID('qh'), new CardValue(CardRank::queen(), CardSuit::hearts()), CardVisibility::faceUp())
        );
        return [
            'happy-path' => [
                'cards_on_pile' => $queenOfHeartsOnTop,
                'origin_class' => TableauPile::class,
                'moved_cards' => DsCards::fromCards(
                    new DsCard(new CardID('js'), new CardValue(CardRank::jack(), CardSuit::spades()), CardVisibility::faceUp()),
                    new DsCard(new CardID('10h'), new CardValue(CardRank::number(10), CardSuit::hearts()), CardVisibility::faceUp())
                ),
                'should_accept' => true,
            ],
            'pile-not-face-up' => [
                'cards_on_pile' => DsCards::fromCards(
                    new DsCard(new CardID('ks'), new CardValue(CardRank::king(), CardSuit::spades()), CardVisibility::faceDown()),
                    new DsCard(new CardID('qh'), new CardValue(CardRank::queen(), CardSuit::hearts()), CardVisibility::faceDown())
                ),
                'origin_class' => TableauPile::class,
                'moved_cards' => DsCards::fromCards(
                    new DsCard(new CardID('js'), new CardValue(CardRank::jack(), CardSuit::spades()), CardVisibility::faceUp()),
                    new DsCard(new CardID('10h'), new CardValue(CardRank::number(10), CardSuit::hearts()), CardVisibility::faceUp())
                ),
                'should_accept' => false,
            ],
            'wrong-colors' => [
                'cards_on_pile' => $queenOfHeartsOnTop,
                'origin_class' => TableauPile::class,
                'moved_cards' => DsCards::fromCards(
                    new DsCard(new CardID('jh'), new CardValue(CardRank::jack(), CardSuit::hearts()), CardVisibility::faceUp()),
                    new DsCard(new CardID('10s'), new CardValue(CardRank::number(10), CardSuit::spades()), CardVisibility::faceUp())
                ),
                'should_accept' => false,
            ],
            'wrong-value' => [
                'cards_on_pile' => $queenOfHeartsOnTop,
                'origin_class' => TableauPile::class,
                'moved_cards' => DsCards::fromCards(
                    new DsCard(new CardID('kc'), new CardValue(CardRank::king(), CardSuit::clubs()), CardVisibility::faceUp())
                ),
                'should_accept' => false,
            ],
        ];
    }
    public function testPossibleMovesWithNonEmptyPile()
    {
        $this->tableauPile = new DsTableauPile(
            $this->gameId,
            new PileWithValidation(
                new FakePile(
                    new PileID('tableau-pile-2'),
                    new FakeCards(Collection::from([
                        FakeCard::fromUuid('down-1', CardVisibility::faceDown()),
                        FakeCard::fromUuid('down-2', CardVisibility::faceDown()),
                        FakeCard::fromUuid('up-1', CardVisibility::faceUp()),
                        FakeCard::fromUuid('up-2', CardVisibility::faceUp()),
                        FakeCard::fromUuid('up-3', CardVisibility::faceUp()),
                    ]))
                )
            )
        );

        // moves are possible for any number of visible top cards to tableau or foundation piles if they accept the move
        $tableau1 = $this->createMock(TableauPile::class);
        $tableau2 = $this->createMock(TableauPile::class);
        $foundation1 = $this->createMock(FoundationPile::class);
        $tableau1->method('pileId')->willReturn(new PileID('t1'));
        $tableau2->method('pileId')->willReturn(new PileID('t2'));
        $foundation1->method('pileId')->willReturn(new PileID('f1'));

        $tableau1->method('accepts')->willReturn(true);
        $tableau2->method('accepts')->willReturn(false);
        $foundation1->method('accepts')->willReturn(true);

        $acceptingTargets = 2;
        $visibleCards = 3;

        $actualPossibleMoves = $this->tableauPile->possibleMoves($tableau1, $tableau2, $foundation1);
        $this->assertCount($acceptingTargets * $visibleCards, $actualPossibleMoves);
        foreach ($actualPossibleMoves as $move) {
            $this->assertInstanceOf(MoveCards::class, $move);
        }
    }
    public function testPossibleMovesWithFaceDownPile()
    {
        $this->tableauPile = new DsTableauPile(
            $this->gameId,
            new PileWithValidation(
                new FakePile(
                    new PileID('tableau-pile-3'),
                    new FakeCards(Collection::from([
                        FakeCard::fromUuid('down-1', CardVisibility::faceDown()),
                        FakeCard::fromUuid('down-2', CardVisibility::faceDown()),
                    ]))
                )
            )
        );
        $otherTableau = $this->createMock(TableauPile::class);
        $otherTableau->method('accepts')->willReturn(true);
        $actualPossibleMoves = $this->tableauPile->possibleMoves($otherTableau);
        $this->assertCount(1, $actualPossibleMoves);
        $this->assertInstanceOf(TurnCard::class, \iterator_to_array($actualPossibleMoves)[0]);
    }
    public function testShowCard()
    {
        $pile = new FakePile(
            new PileID('tableau-pile-4'),
            new FakeCards(Collection::from([
                FakeCard::fromUuid('down-1', CardVisibility::faceDown()),
                FakeCard::fromUuid('down-2', CardVisibility::faceDown()),
            ]))
        );
        $this->tableauPile = new DsTableauPile(
            $this->gameId,
            $pile
        );
        $this->tableauPile->showCard();
        $this->assertEquals(
            new FakePile(
                new PileID('tableau-pile-4'),
                new FakeCards(Collection::from([
                    FakeCard::fromUuid('down-1', CardVisibility::faceDown()),
                    FakeCard::fromUuid('down-2', CardVisibility::faceUp()),
                ]))
            ),
            $pile->transition()
        );

        //TODO assert event payload?
    }
}
