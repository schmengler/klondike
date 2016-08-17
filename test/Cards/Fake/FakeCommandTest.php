<?php
namespace SSE\Cards\Fake;


class FakeCommandTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var FakeCommand
     */
    private $fakeCommand;

    protected function setUp()
    {
        $this->fakeCommand = new FakeCommand('whatever');
    }
    public function testToString()
    {
        $this->assertEquals('whatever', $this->fakeCommand->__toString());
    }
    public function testInvoked()
    {
        $this->assertFalse($this->fakeCommand->invoked());
        $this->fakeCommand->__invoke();
        $this->assertTrue($this->fakeCommand->invoked());
    }
}
