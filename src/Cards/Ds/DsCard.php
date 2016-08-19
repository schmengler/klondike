<?php
namespace SSE\Cards\Ds;

use SSE\Cards\Card;
use SSE\Cards\CardID;
use SSE\Cards\CardValue;
use SSE\Cards\CardVisibility;

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
	public function id() : CardID
    {
        return $this->id;
    }
	public function value() : CardValue
    {
        return $this->value;
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