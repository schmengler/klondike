<?php
namespace SSE\Cards\Ds;

use SSE\Cards\Card;
use SSE\Cards\CardID;
use SSE\Cards\CardSuit;
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

	//test
    public function __toString() : string
    {
        if ($this->visibility() == CardVisibility::faceDown()) {
            return \chr(27) . "[34m" .  '[X]' . \chr(27) . '[0m';
        }
        $ansi = $this->value()->suit()->colorEquals(CardSuit::hearts()) ? '1' : '7';
        return \chr(27) . "[3{$ansi}m" .  '['. $this->value()->suit() . $this->value()->rank()  .']' . \chr(27) . '[0m';
    }
}