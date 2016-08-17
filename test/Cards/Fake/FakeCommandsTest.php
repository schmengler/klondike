<?php
namespace SSE\Cards\Fake;

use SSE\Cards\Cards;
use SSE\Cards\CardVisibility;

class FakeCommandsTest extends \PHPUnit_Framework_TestCase
{
	public function testIterator()
	{
		$expectedCommands = [new FakeCommand('do-this'), new FakeCommand('do-that')];
	    $commands = FakeCommands::fromNames('do-this', 'do-that');
		$this->assertEquals($expectedCommands, \iterator_to_array($commands));
	}
}