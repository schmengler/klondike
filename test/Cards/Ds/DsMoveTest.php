<?php
namespace SSE\Cards\Ds;

use SSE\Cards\Fake\FakeCards;
use SSE\Cards\Fake\FakeCommands;
use SSE\Cards\Fake\FakeEvent;
use SSE\Cards\Fake\FakeEventBuilder;
use SSE\Cards\Fake\FakeMoveOrigin;
use SSE\Cards\GameID;
use SSE\Cards\InvalidMove;
use SSE\Cards\Move;
use SSE\Cards\MoveTarget;

/**
 * @covers SSE\Cards\Ds\DsMove
 */
class DsMoveTest extends \PHPUnit_Framework_TestCase
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
			->with($incompleteMove)
			->willReturn($expectedEvent);
		
		$this->assertSame($expectedEvent, $incompleteMove->to($this->moveTarget));
	}
	public function testPreventMoveTwice()
    {
        $move = $this->incompleteMoveWithCardIds('a-card');
        $move->to($this->moveTarget);
        $this->setExpectedExceptionRegExp(InvalidMove::class, '/Move already finished/');
        $move->to($this->moveTarget);
    }
	private function incompleteMoveWithCardIds(string ...$uuids) : Move
	{
		return new DsMove(
		    new FakeMoveOrigin(FakeCommands::fromNames('whatever')),
			FakeCards::fromUuids(...$uuids)
		);
	}
	private function fakeEvent($payload) : FakeEvent
	{
		return $this->eventBuilder->withPayload($payload)->create();
	}
}