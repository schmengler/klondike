<?php
namespace SSE\Cards;

use SSE\Cards\Ds\DsPile;
use SSE\Cards\Fake\FakeCard;
use SSE\Cards\Fake\FakeCards;

/**
 * @covers SSE\Cards\PileWithValidation
 */
class PileWithValidationTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var PileWithValidation
	 */
	private $pile;
    /**
     * @var Pile|\PHPUnit_Framework_MockObject_MockObject
     */
    private $pileMock;

    protected function setUp()
    {
        $this->pileMock = $this->getMockForAbstractClass(Pile::class);
        $this->pile = new PileWithValidation($this->pileMock);
    }

    private function createPileWithCards(Card ...$cards)
	{
	    //TODO use FakePile when implemented
		return new PileWithValidation(DsPile::fromSingleCards(new PileID('fake'), ...$cards));
	}

	public function testTakeTooMany()
	{
		$cards = [
			FakeCard::fromUuid('xxx'),
			FakeCard::fromUuid('yyy'),
			FakeCard::fromUuid('zzz')
		];
		$pile = $this->createPileWithCards(...$cards);
		
		$this->setExpectedExceptionRegExp(InvalidPileOperation::class, '/Cannot take 4 cards from pile of 3 cards/');
		$pile->top(4);
	}
	
	public function testDropTooMany()
	{
		$cards = [
			FakeCard::fromUuid('aaa'),
			FakeCard::fromUuid('bbb'),
			FakeCard::fromUuid('ccc'),
		];
        $pile = $this->createPileWithCards(...$cards);
		
		$this->setExpectedExceptionRegExp(InvalidPileOperation::class, '/Cannot drop 4 cards from pile of 3 cards/');
		$pile->drop(4);
	}
	
	public function testTurnTopCardOnEmptyPile()
	{
		$this->setExpectedExceptionRegExp(InvalidPileOperation::class, '/Cannot turn top card of empty pile/');
        $pile = $this->createPileWithCards();
		$pile->turnTopCard();
	}
	public function testAllDelegation()
    {
        $this->pileMock->expects($this->once())->method('all');
        $this->pile->all();
    }
    public function testCountDelegation()
    {
        $this->pileMock->expects($this->once())->method('count')->willReturn(10);
        $this->assertEquals(10, $this->pile->count());
    }
    public function testDropAllDelegation()
    {
        $this->pileMock->expects($this->once())->method('dropAll');
        $this->pile->dropAll();
    }
	public function testAddDelegation()
    {
        $cards = FakeCards::fromUuids();
        $this->pileMock->expects($this->once())->method('add')->with($cards);
        $this->pile->add($cards);
    }
}