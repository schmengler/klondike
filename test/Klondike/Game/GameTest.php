<?php
namespace SSE\Klondike\Game;

class GameTest extends \PHPUnit_Framework_TestCase
{
	public function testInstantiation()
	{
		$game = new Game();
		$this->assertInstanceOf(Game::class, $game);
	}
}