<?php
namespace SSE\Cards\Fake;

use SSE\Cards\CardID;
use SSE\Cards\Card;
use SSE\Cards\CardRank;
use SSE\Cards\CardSuit;
use SSE\Cards\CardValue;
use SSE\Cards\CardVisibility;
/**
 * Fake card with dummy values, for testing
 */
final class FakeCard implements Card
{
    /**
     * @var CardID
     */
	private $cardId;
    /**
     * @var CardVisibility
     */
	private $visibility;
    /**
     * @var CardValue
     */
    private $value;

    public function __construct(CardID $cardId, CardVisibility $visibility, CardValue $value)
	{
		$this->cardId = $cardId;
		$this->visibility = $visibility;
        $this->value = $value;
    }
    public static function fromUuid(string $uuid, CardVisibility $visibility = null)
    {
        return new self(
            new CardID($uuid),
            $visibility ?? CardVisibility::faceDown(),
            new CardValue(CardRank::ace(), CardSuit::spades())
        );
    }

    public function id() : CardID
    {
        return $this->cardId;
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
		$clone = clone $this;
		$clone->visibility = $clone->visibility->opposite();
		return $clone; 
	}
}