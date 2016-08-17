<?php
namespace SSE\Cards\Ds;

use SSE\Cards\CardID;
use SSE\Cards\CardRank;
use SSE\Cards\CardSuit;
use SSE\Cards\CardValue;
use SSE\Cards\CardVisibility;

/**
 * @covers DsCard
 */
class DsCardTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DsCard
     */
	private $card;
	public function testTurnOver()
	{
		$this->card = new DsCard(
				new CardID('ace-of-spades'),
				new CardValue(CardRank::ace(), CardSuit::spades()),
				CardVisibility::faceDown());
		$this->assertEquals(CardVisibility::faceDown(), $this->card->visibility(), 'original visibility');
		$this->assertEquals(CardVisibility::faceUp(), $this->card->turnOver()->visibility(), 'visibility of turned card');
		$this->assertEquals(CardVisibility::faceDown(), $this->card->visibility(), 'original object must be unchanged');
	}
}