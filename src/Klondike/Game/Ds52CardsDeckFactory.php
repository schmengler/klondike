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
        $cardDeque = new \Ds\Deque();
        foreach ([CardSuit::hearts(), CardSuit::diamonds(), CardSuit::clubs(), CardSuit::spades()] as $suit) {
            foreach (\range(1, 13) as $n) {
                $rank = CardRank::number($n);
                $cardDeque->push(
                    new DsCard(
                        new CardID(\md5($suit . "-" . $rank)),
                        new CardValue($rank, $suit),
                        CardVisibility::faceDown()
                    )
                );
            }
        }
        return new DsDeck(new DsCards($cardDeque), DsPile::fromSingleCards(new PileID('deck-pile')));
	}
}