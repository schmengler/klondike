<?php
namespace SSE\Cards\Ds;

use SSE\Cards\Fake\FakeCommand;

/**
 * @covers SSE\Cards\Ds\DsCommands
 */
class DsCommandsTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var DsCommands
	 */
	private $commands;

	public function testIterator()
	{
		$commands = [new FakeCommand('xxx'), new FakeCommand('yyy')];
		$this->commands = DsCommands::fromCommands(...$commands);
		$this->assertEquals($commands, \iterator_to_array($this->commands));
	}
    public function testCount()
    {
        $commands = [new FakeCommand('zzz'), new FakeCommand('qqq')];
        $this->commands = DsCommands::fromCommands(...$commands);
        $this->assertEquals(\count($commands), $this->commands->count());
    }
}