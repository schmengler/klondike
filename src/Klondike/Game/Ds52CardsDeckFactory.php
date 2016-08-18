<?php
namespace SSE\Klondike\Game;

use SSE\Cards\CardID;
use SSE\Cards\CardRank;
use SSE\Cards\CardSuit;
use SSE\Cards\CardValue;
use SSE\Cards\CardVisibility;
use SSE\Cards\Deck;
use SSE\Cards\DeckFactory;
use SSE\Cards\Ds\DsCard;
use SSE\Cards\Ds\DsCards;
use SSE\Cards\Ds\DsDeck;
use SSE\Cards\Ds\DsPile;
use SSE\Cards\PileID;

final class Ds52CardsDeckFactory implements DeckFactory
{
	public function create() : Deck
	{
		//TODO construct deck with 52 cards, face down, new UUIDs
        $cardDeque = new \Ds\Deque();
        foreach (range(1, 52) as $n) {
            $cardDeque->push(
                new DsCard(
                    new CardID($n),
                    new CardValue(
                        CardRank::number($n),
                        CardSuit::hearts()
                    ),
                    CardVisibility::faceDown()
                )
            );
        }
        $cards = new DsCards($cardDeque);
        return new DsDeck($cards, DsPile::fromSingleCards(new PileID('deck-pile')));
	}
}