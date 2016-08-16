<?php
namespace Klondike\Move;

use Klondike\Move\IncompleteMove;
use Klondike\Field\MoveTarget;
use Klondike\Move\Event\CardsMoved;
use Klondike\Move\Event\FakeEventBuilder;
use Klondike\Value\GameID;
use Klondike\Element\FakeCards;
use Klondike\Move\Event\FakeEvent;
class IncompleteMoveTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var \PHPUnit_Framework_MockObject_MockObject|MoveTarget
	 */
	private $moveTarget;
	/**
	 * @var FakeEventBuilder
	 */
	private $eventBuilder;
	
	protected function setUp()
	{
		$this->moveTarget = $this->getMockForAbstractClass(MoveTarget::class);
		$this->eventBuilder = new FakeEventBuilder(new GameID('the-game'));
	}
	public function testSuccess()
	{
		$expectedEvent = $this->fakeEvent('some-cards-moved');

		$incompleteMove = $this->incompleteMoveWithCardIds('card-1', 'card-2');

		$this->moveTarget->expects($this->once())
			->method('receive')
			->with($incompleteMove->cards())
			->willReturn($expectedEvent);
		
		$this->assertSame($expectedEvent, $incompleteMove->to($this->moveTarget));
	}
	private function incompleteMoveWithCardIds(string ...$uuids) : Move
	{
		return new IncompleteMove(
			FakeCards::fromUuids(...$uuids)
		);
	}
	private function fakeEvent($payload) : FakeEvent
	{
		return $this->eventBuilder->withPayload($payload)->create();
	}
}