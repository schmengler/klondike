<?php
namespace SSE\Cards;

use SSE\Cards\Ds\DsPile;
use SSE\Cards\Fake\FakeCard;

/**
 * @covers PileWithValidation
 */
class DsPileTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var PileWithValidation
	 */
	private $pile;
	private function createPileWithCards(Card ...$cards)
	{
	    //TODO use FakePile when implemented
		$this->pile = new PileWithValidation(DsPile::fromSingleCards(new PileID('fake'), ...$cards));
	}
	public function testTakeTooMany()
	{
		$cards = [
			FakeCard::fromUuid('xxx'),
			FakeCard::fromUuid('yyy'),
			FakeCard::fromUuid('zzz')
		];
		$this->createPileWithCards(...$cards);
		
		$this->setExpectedExceptionRegExp(InvalidPileOperation::class, '/Cannot take 4 cards from pile of 3 cards/');
		$this->pile->top(4);
	}
	
	public function testDropTooMany()
	{
		$cards = [
			FakeCard::fromUuid('aaa'),
			FakeCard::fromUuid('bbb'),
			FakeCard::fromUuid('ccc'),
		];
		$this->createPileWithCards(...$cards);
		
		$this->setExpectedExceptionRegExp(InvalidPileOperation::class, '/Cannot drop 4 cards from pile of 3 cards/');
		$this->pile->drop(4);
	}
	
	public function testTurnTopCardOnEmptyPile()
	{
		$this->setExpectedExceptionRegExp(InvalidPileOperation::class, '/Cannot turn top card of empty pile/');
		$this->createPileWithCards();
		$this->pile->turnTopCard();
	}
}