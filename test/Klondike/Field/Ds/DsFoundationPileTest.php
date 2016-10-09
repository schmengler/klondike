<?php
namespace SSE\Klondike\Field\Ds;


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
use SSE\Klondike\Field\TableauPile;
use SSE\Klondike\Move\Command\MoveCards;
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

    /**
     * @dataProvider dataAcceptedMoves
     */
    public function testAcceptRules(DsCards $cardsOnPile, string $originClass, DsCards $movedCards, bool $shouldAccept)
    {
        $this->foundationPile = new DsFoundationPile(
            $this->gameId,
            new PileWithValidation(
                new DsPile(
                    new PileID('foundation-pile-2'),
                    $cardsOnPile
                )
            )
        );
        $this->assertEquals(
            $shouldAccept,
            $this->foundationPile->accepts(new DsMove(
                $this->createMock($originClass),
                $movedCards
            ))
        );
    }
    public static function dataAcceptedMoves()
    {
        return [
            'HA_on_empty' => [
                'cards_on_pile' => DsCards::fromCards(),
                'origin_class' => TableauPile::class,
                'moved_cards' => DsCards::fromCards(
                    new DsCard(
                        new CardID('H-A'),
                        new CardValue(CardRank::ace(), CardSuit::hearts()),
                        CardVisibility::faceUp()
                    )
                ),
                'should_accept' => true,
            ],
            'HK_on_empty' => [
                'cards_on_pile' => DsCards::fromCards(),
                'origin_class' => TableauPile::class,
                'moved_cards' => DsCards::fromCards(
                    new DsCard(
                        new CardID('H-K'),
                        new CardValue(CardRank::king(), CardSuit::hearts()),
                        CardVisibility::faceUp()
                    )
                ),
                'should_accept' => false,
            ],
            'H2_on_HA' => [
                'cards_on_pile' => DsCards::fromCards(
                    new DsCard(
                        new CardID('H-A'),
                        new CardValue(CardRank::ace(), CardSuit::hearts()),
                        CardVisibility::faceUp()
                    )
                ),
                'origin_class' => TableauPile::class,
                'moved_cards' => DsCards::fromCards(
                    new DsCard(
                        new CardID('H-2'),
                        new CardValue(CardRank::number(2), CardSuit::hearts()),
                        CardVisibility::faceUp()
                    )
                ),
                'should_accept' => true,
            ],
            'H2_on_HA-facedown' => [
                'cards_on_pile' => DsCards::fromCards(
                    new DsCard(
                        new CardID('H-A'),
                        new CardValue(CardRank::ace(), CardSuit::hearts()),
                        CardVisibility::faceUp()
                    )
                ),
                'origin_class' => TableauPile::class,
                'moved_cards' => DsCards::fromCards(
                    new DsCard(
                        new CardID('H-2'),
                        new CardValue(CardRank::number(2), CardSuit::hearts()),
                        CardVisibility::faceDown()
                    )
                ),
                'should_accept' => false,
            ],
            'H2_on_CA' => [
                'cards_on_pile' => DsCards::fromCards(
                    new DsCard(
                        new CardID('C-A'),
                        new CardValue(CardRank::ace(), CardSuit::clubs()),
                        CardVisibility::faceUp()
                    )
                ),
                'origin_class' => TableauPile::class,
                'moved_cards' => DsCards::fromCards(
                    new DsCard(
                        new CardID('H-2'),
                        new CardValue(CardRank::number(2), CardSuit::hearts()),
                        CardVisibility::faceUp()
                    )
                ),
                'should_accept' => false,
            ],
            'H3_on_HA' => [
                'cards_on_pile' => DsCards::fromCards(
                    new DsCard(
                        new CardID('H-A'),
                        new CardValue(CardRank::ace(), CardSuit::hearts()),
                        CardVisibility::faceUp()
                    )
                ),
                'origin_class' => TableauPile::class,
                'moved_cards' => DsCards::fromCards(
                    new DsCard(
                        new CardID('H-3'),
                        new CardValue(CardRank::number(3), CardSuit::hearts()),
                        CardVisibility::faceUp()
                    )
                ),
                'should_accept' => false,
            ],
            'multiple' => [
                'cards_on_pile' => DsCards::fromCards(
                    new DsCard(
                        new CardID('H-A'),
                        new CardValue(CardRank::ace(), CardSuit::hearts()),
                        CardVisibility::faceUp()
                    )
                ),
                'origin_class' => TableauPile::class,
                'moved_cards' => DsCards::fromCards(
                    new DsCard(
                        new CardID('H-2.1'),
                        new CardValue(CardRank::number(2), CardSuit::hearts()),
                        CardVisibility::faceUp()
                    ),
                    new DsCard(
                        new CardID('H-2.2'),
                        new CardValue(CardRank::number(2), CardSuit::hearts()),
                        CardVisibility::faceUp()
                    )
                ),
                'should_accept' => false,
            ],
        ];
    }
    public function testPossibleMovesWithEmptyPile()
    {
        $this->foundationPile= new DsFoundationPile($this->gameId, FakePile::fromUuids());
        $tableau = $this->createMock(TableauPile::class);
        $tableau->expects($this->never())->method('accepts');
        $actualPossibleMoves = $this->foundationPile->possibleMoves($tableau);
        $this->assertCount(0, $actualPossibleMoves);
    }
    public function testPossibleMovesWithNonEmptyPile()
    {
        // moves are possible for top card to tableau piles if they accept the card
        $tableau1 = $this->createMock(TableauPile::class);
        $tableau2 = $this->createMock(TableauPile::class);
        $tableau3 = $this->createMock(TableauPile::class);

        $tableau1->method('accepts')->willReturn(true);
        $tableau2->method('accepts')->willReturn(false);
        $tableau3->method('accepts')->willReturn(true);

        $tableau1->method('pileId')->willReturn(new PileID('t1'));
        $tableau2->method('pileId')->willReturn(new PileID('t2'));
        $tableau3->method('pileId')->willReturn(new PileID('t3'));

        $actualPossibleMoves = $this->foundationPile->possibleMoves($tableau1, $tableau2, $tableau3);
        $this->assertCount(2, $actualPossibleMoves);
        foreach ($actualPossibleMoves as $move) {
            $this->assertInstanceOf(MoveCards::class, $move);
        }
    }
}
