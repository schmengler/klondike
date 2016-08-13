<?php
namespace Klondike;

use Klondike\Game\Game;
class GameTest extends \PHPUnit_Framework_TestCase
{
	public function testInstantiation()
	{
		$game = new Game();
		$this->assertInstanceOf(Game::class, $game);
	}
}