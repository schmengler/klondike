<?php
namespace SSE\Cards\Ds;


use SSE\Cards\Fake\FakeCards;
use SSE\Cards\PileID;

/**
 * @covers SSE\Cards\Ds\DsDeck
 */
class DsDeckTest extends \PHPUnit_Framework_TestCase
{
    public function testSize()
    {
        $cardIds = ['un', 'dos', 'tres'];
        $deck = $this->createDeckFromCardIds($cardIds);
        $this->assertEquals(\count($cardIds), $deck->size());
    }
    public function testPile()
    {
        $cardIds = ['one', 'two', 'three'];
        $deck = $this->createDeckFromCardIds($cardIds);
        $this->assertEquals(
            \iterator_to_array(FakeCards::fromUuids(...$cardIds)),
            \iterator_to_array($deck->pile()->all())
        );
    }
    /**
     * @dataProvider dataPermutation
     */
    public function testPermutation(array $originalIds, array $permutation, array $expectedIds)
    {
        $deck = $this->createDeckFromCardIds($originalIds);
        $this->assertEquals(
            \iterator_to_array($this->createDeckFromCardIds($expectedIds)->pile()->all()),
            \iterator_to_array($deck->permutation(...$permutation)->pile()->all()));
        $this->assertEquals(
            \iterator_to_array($this->createDeckFromCardIds($originalIds)->pile()->all()),
            \iterator_to_array($deck->pile()->all()), 'Original should be unchanged');
    }
    public static function dataPermutation()
    {
        return [
            [
                ['id-1', 'id-2', 'id-3', 'id-4'],
                [3, 0, 1, 2],
                ['id-2', 'id-3', 'id-4', 'id-1'],
            ],
            [
                ['a', 'b', 'y', 'x'],
                [-1, 0, 10, 3],
                ['a', 'b', 'x', 'y'],
            ],
            [
                ['id-1', 'id-2'],
                [0, 0],
                ['id-1', 'id-2'],
            ],
        ];
    }

    /**
     * @param $cardIds
     * @return DsDeck
     */
    protected function createDeckFromCardIds($cardIds)
    {
        $deck = new DsDeck(DsCards::fromCards(...FakeCards::fromUuids(...$cardIds)), DsPile::fromSingleCards(new PileID('pile')));
        return $deck;
    }
}
