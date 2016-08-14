<?php
namespace Klondike\Element;

use Klondike\Value\CardID;
use Klondike\Value\CardValue;
use Klondike\Value\Suit;
use Klondike\Value\Rank;
use Klondike\Value\CardVisibility;

class DsCardTest extends \PHPUnit_Framework_TestCase
{
	private $card;
	public function testTurnOver()
	{
		$this->card = new DsCard(
				new CardID('ace-of-spades'),
				new CardValue(Suit::SPADES(), new Rank(Rank::ACE)),
				CardVisibility::faceDown());
		$this->assertEquals(CardVisibility::faceDown(), $this->card->visibility(), 'original visibility');
		$this->assertEquals(CardVisibility::faceUp(), $this->card->turnOver()->visibility(), 'visibility of turned card');
		$this->assertEquals(CardVisibility::faceDown(), $this->card->visibility(), 'original object must be unchanged');
	}
}