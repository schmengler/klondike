<?php
namespace SSE\Cards;

final class DeckWithValidation implements Deck
{
    /**
     * @var Deck
     */
    private $deck;

    public function __construct(Deck $deck)
    {
        $this->deck = $deck;
    }

    public function size() : int
    {
        return $this->deck->size();
    }

    public function pile() : Pile
    {
        return $this->deck->pile();
    }

    public function permutation(int ...$p) : Deck
    {
        if (\count($p) !== $this->deck->size()) {
            throw new InvalidPermutation(\sprintf(
                'Permutation array must have same size as deck. Expected: %d Given %d',
                $this->deck->size(),
                \count($p)
            ));
        }
        return new self(
            $this->deck->permutation(...$p)
        );
    }

}