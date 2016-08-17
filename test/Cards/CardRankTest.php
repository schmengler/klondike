<?php
namespace SSE\Cards;

/**
 * @covers CardRank
 */
class CardRankTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider dataStringRepresentation
     * @param $expectedString
     * @param $rankValue
     */
	public function testStringRepresentation($expectedString, $rankValue)
	{
	    $this->assertEquals($expectedString, (string) new CardRank($rankValue));
	}
	public static function dataStringRepresentation()
    {
        return [
            ['A', CardRank::ACE],
            ['2', 2],
            ['3', 3],
            ['4', 4],
            ['5', 5],
            ['6', 6],
            ['7', 7],
            ['8', 8],
            ['9', 9],
            ['10', 10],
            ['J', CardRank::JACK],
            ['Q', CardRank::QUEEN],
            ['K', CardRank::KING],
        ];
    }

	public function testPictureConstructors()
    {
        $this->assertEquals(new CardRank(CardRank::ACE), CardRank::ace());
        $this->assertEquals(new CardRank(CardRank::JACK), CardRank::jack());
        $this->assertEquals(new CardRank(CardRank::QUEEN), CardRank::queen());
        $this->assertEquals(new CardRank(CardRank::KING), CardRank::king());
    }

    /**
     * @dataProvider dataNumbers
     * @param $number
     */
	public function testNumberConstructor($number)
    {
        $this->assertEquals(new CardRank($number), CardRank::number($number));
    }
    public static function dataNumbers()
    {
        return [
            'lowest' => [2],
            'highest' => [10],
            // no validation, any numbers are possible
            'ace_as_number' => [1],
            'jack_as_number' => [11],
            'any_high_number' => [42],
            'negative_number' => [-1],
            'zero' => [0],
        ];
    }
}