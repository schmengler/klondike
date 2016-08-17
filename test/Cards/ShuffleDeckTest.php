<?php
namespace SSE\Cards;

/**
 * @covers SSE\Cards\ShuffleDeck
 */
class ShuffleDeckTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ShuffleDeck
     */
    private $shuffleDeck;
    /**
     * @var Deck|\PHPUnit_Framework_MockObject_MockObject
     */
    private $deckMock;

    protected function setUp()
    {
        $this->deckMock = $this->getMockForAbstractClass(Deck::class);
        $this->shuffleDeck = new ShuffleDeck($this->deckMock);
    }

    public function testShuffle()
    {
        $permutatedDeck = $this->createMock(Deck::class);
        $deckSize = 10;
        $deckMock = $this->createMock(Deck::class);
        $deckMock
            ->expects($this->once())
            ->method('permutation')
            ->willReturnCallback(function(...$p) use ($deckSize, $permutatedDeck) {
                $this->assertCount($deckSize, $p);
                return $permutatedDeck;
            });
        $deckMock
            ->method('size')
            ->willReturn($deckSize);
        $shuffleDeck = new ShuffleDeck($deckMock);
        $this->assertInstanceOf(ShuffleDeck::class, $shuffleDeck->shuffle());
    }

    public function testSizeDelegation()
    {
        $this->deckMock->expects($this->once())->method('size');
        $this->shuffleDeck->size();
    }
    public function testPileDelegation()
    {
        $this->deckMock->expects($this->once())->method('pile');
        $this->shuffleDeck->pile();
    }
    public function testPermutationDelegation()
    {
        $permutation = [1, 0];
        $this->deckMock->expects($this->once())->method('permutation')->with(...$permutation);
        $this->shuffleDeck->permutation(...$permutation);
    }
}
