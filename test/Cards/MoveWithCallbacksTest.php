<?php
namespace SSE\Cards;

use SSE\Cards\Fake\FakeEvent;
use SSE\Cards\Fake\FakeEventBuilder;

class MoveWithCallbacksTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var \PHPUnit_Framework_MockObject_MockObject
	 */
	private $onSuccessMock;
	/**
	 * @var \PHPUnit_Framework_MockObject_MockObject
	 */
	private $onCancelMock;
	/**
	 * @var \PHPUnit_Framework_MockObject_MockObject|Move
	 */
	private $move;
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
		$this->onSuccessMock = $this->getMockBuilder(\stdClass::class)
			->setMethods(['__invoke'])
			->getMock();
		$this->onCancelMock = $this->getMockBuilder(\stdClass::class)
			->setMethods(['__invoke'])
			->getMock();
		$this->move = $this->getMockForAbstractClass(Move::class);
		$this->moveTarget = $this->getMockForAbstractClass(MoveTarget::class);
		$this->eventBuilder = new FakeEventBuilder(new GameID('the-game'));
	}
	public function testSuccess()
	{
		$expectedEvent = $this->fakeEvent('some-cards-moved');
		$this->onSuccessMock->expects($this->once())->method('__invoke');
		$this->onCancelMock->expects($this->never())->method('__invoke');

		$this->move->expects($this->once())
			->method('to')
			->with($this->moveTarget)
			->willReturn($expectedEvent);
		
		$this->assertSame($expectedEvent, $this->smartMove()->to($this->moveTarget));
	}
	public function testFailure()
	{
		$expectedException = new \RuntimeException('something went wrong');
		$this->onSuccessMock->expects($this->never())->method('__invoke');
		$this->onCancelMock->expects($this->once())->method('__invoke');

		$this->move->expects($this->once())
			->method('to')
			->with($this->moveTarget)
			->willThrowException($expectedException);

		$this->setExpectedException(\get_class($expectedException), $expectedException->getMessage());
		$this->smartMove()->to($this->moveTarget);
	}
	private function smartMove() : Move
	{
		return new MoveWithCallbacks(
			$this->move,
			$this->onSuccessMock,
			$this->onCancelMock
		);
	}
	private function fakeEvent($payload) : FakeEvent
	{
		return $this->eventBuilder->withPayload($payload)->create();
	}
}