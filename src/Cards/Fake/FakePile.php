<?php
namespace SSE\Cards\Fake;

use DusanKasan\Knapsack\Collection;
use SSE\Cards\Cards;
use SSE\Cards\Pile;
use SSE\Cards\PileID;

final class FakePile implements Pile
{
    /**
     * @var Cards
     */
    private $cards;
    /**
     * @var PileID
     */
    private $pileId;
    /**
     * @var FakePile
     */
    private $transition;

    /**
     * FakePile constructor.
     * @param PileID $pileId
     * @param Cards $cards
     */
    public function __construct(PileID $pileId, Cards $cards)
    {
        $this->pileId = $pileId;
        $this->cards = $cards;
    }


    public static function fromUuids(string ...$cards) : FakePile
    {
        return new self(new PileID('fake-pile'), FakeCards::fromUuids(...$cards));
    }

    public function top(int $numberOfCards) : Cards
    {
        return $this->cards->slice(-$numberOfCards);
    }

    public function all() : Cards
    {
        return $this->cards;
    }

    public function drop(int $numberOfCards) : Pile
    {
        return $this->transition = new self($this->pileId, $this->cards->slice(0, -$numberOfCards));
    }

    public function dropAll() : Pile
    {
        return $this->transition = new self($this->pileId, $this->cards->slice(0, 0));
    }

    public function add(Cards $cards) : Pile
    {
        return $this->transition = new self($this->pileId, $this->cards->merge($cards));
    }

    public function turnTopCard() : Pile
    {
        return $this->transition = new self($this->pileId, $this->cards
            ->slice(0, -1)
            ->merge(new FakeCards(
                Collection::from($this->cards->slice(-1)->turnAll()))
            )
        );
    }

    public function count() : int
    {
        return $this->all()->count();
    }


    public function transition() : FakePile
    {
        return $this->transition ? $this->transition->transition() : $this;
    }
}