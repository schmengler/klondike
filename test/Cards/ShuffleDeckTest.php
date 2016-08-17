<?php
namespace SSE\Cards;

/**
 * @covers SSE\Cards\ShuffleDeck
 */
class ShuffleDeckTest extends \PHPUnit_Framework_TestCase
{
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
}
