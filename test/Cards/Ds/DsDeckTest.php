<?php
/**
 * integer_net Magento Module
 *
 * @category   IntegerNet
 * @package    IntegerNet
 * @copyright  Copyright (c) 2016 integer_net GmbH (http://www.integer-net.de/)
 * @author     Fabian Schmengler <fs@integer-net.de>
 */

namespace SSE\Cards\Ds;


use SSE\Cards\Fake\FakeCards;
use SSE\Cards\InvalidPermutation;

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

    /**
     * @param $cardIds
     * @return DsDeck
     */
    protected function createDeckFromCardIds($cardIds)
    {
        $deck = new DsDeck(DsCards::fromCards(...FakeCards::fromUuids(...$cardIds)), DsPile::fromSingleCards());
        return $deck;
    }
}
