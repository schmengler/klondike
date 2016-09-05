<?php
namespace SSE\Cards;

/**
 * @covers MoveTargetWithValidation
 */
class MoveTargetWithValidationTest extends \PHPUnit_Framework_TestCase
{
    public function testCannotReceiveUnacceptedMove()
    {
        $moveDummy = $this->createMock(Move::class);
        $moveTargetMock = $this->createMock(MoveTarget::class);
        $moveTargetMock->method('pileId')->willReturn(new PileID('evil pile'));
        $moveTargetMock->expects($this->once())->method('accepts')->with($moveDummy)->willReturn(false);
        $moveTargetMock->expects($this->never())->method('receive');
        $moveTarget = new MoveTargetWithValidation($moveTargetMock);

        $this->setExpectedExceptionRegExp(InvalidMove::class, '/not accepted/');
        $moveTarget->receive($moveDummy);
    }
}
