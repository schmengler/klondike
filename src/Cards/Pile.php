<?php
namespace SSE\Cards;

/**
 * Immutable pile of cards
 */
interface Pile extends \Countable
{
    /**
     * Return pile id
     */
    public function id() : PileID;
	/**
	 * Return $numberOfCards cards from top
	 */
	public function top(int $numberOfCards) : Cards;
	/**
	 * Return all cards
	 */
	public function all() : Cards;
	/**
	 * Return pile without top $numberOfCards cards
	 */
	public function drop(int $numberOfCards) : Pile;
	/**
	 * Return pile with all cards removed
	 */
	public function dropAll() : Pile;
	/**
	 * Return pile with $cards on top
	 */
	public function add(Cards $cards) : Pile;
	/**
	 * Return pile with top card turned over
	 */
	public function turnTopCard() : Pile;
}
