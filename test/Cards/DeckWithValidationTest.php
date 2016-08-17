<?php
namespace SSE\Cards\Ds;


use SSE\Cards\Deck;
use SSE\Cards\DeckWithValidation;
use SSE\Cards\Fake\FakeCards;
use SSE\Cards\InvalidPermutation;

class DeckWithValidationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DeckWithValidation
     */
    private $deckWithValidation;
    /**
     * @var Deck|\PHPUnit_Framework_MockObject_MockObject
     */
    private $deckMock;
    protected function setUp()
    {
        $this->deckMock = $this->getMockForAbstractClass(Deck::class);
        $this->deckWithValidation = new DeckWithValidation($this->deckMock);
    }
    public function testSizeDelegation()
    {
        $this->deckMock->expects($this->once())->method('size')->willReturn(42);
        $this->assertEquals(42, $this->deckWithValidation->size());
    }
    public function testPileDelegation()
    {
        $pile = DsPile::fromSingleCards();
        $this->deckMock->expects($this->once())->method('pile')->willReturn($pile);
        $this->assertSame($pile, $this->deckWithValidation->pile());
    }
    public function testPermutationDelegation()
    {
        $permutated = $this->getMockForAbstractClass(Deck::class);
        $permutation = [1, 0];
        $this->deckMock->method('size')->willReturn(\count($permutation));
        $this->deckMock->expects($this->once())->method('permutation')->with(...$permutation)->willReturn($permutated);
        $this->assertInstanceOf(DeckWithValidation::class, $this->deckWithValidation->permutation(...$permutation));
    }
    /**
     * @dataProvider dataInvalidPermutation
     */
    public function testPermutationFailsWithInconsistentSize($cardIds, $permutation)
    {
        $this->setExpectedExceptionRegExp(InvalidPermutation::class, '/Permutation array must have same size as deck. Expected: \d+ Given \d+/');
        $this->createDeckFromCardIds($cardIds)->permutation(...$permutation);
    }
    public static function dataInvalidPermutation()
    {
        return [
            [
                ['card-1', 'card-2'], [0]
            ],
            [
                ['card-1', 'card-2'], [0, 1, 2]
            ],
        ];
    }

    protected function createDeckFromCardIds($cardIds) : DeckWithValidation
    {
        return new DeckWithValidation(
            new DsDeck(
                DsCards::fromCards(...FakeCards::fromUuids(...$cardIds)),
                DsPile::fromSingleCards()
            )
        );
    }
}
