<?php
namespace Klondike\Element;

use Klondike\Value\CardID;
use Klondike\Value\CardValue;
use Klondike\Value\CardVisibility;
final class DsCard implements Card
{
	private $id;
	private $value;
	private $visibility;
	
	public function __construct(CardID $id, CardValue $value, CardVisibility $visibility)
	{
		$this->id = $id;
		$this->value = $value;
		$this->visibility = $visibility;
	}
	public function visibility() : CardVisibility
	{
		return $this->visibility;
	}
	
	public function turnOver() : Card
	{
		return new self($this->id, $this->value, $this->visibility->opposite());
	}
}