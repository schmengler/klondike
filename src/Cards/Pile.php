<?php
namespace SSE\Cards;

/**
 * Immutable pile of cards
 */
interface Pile
{
	/**
	 * Return $numberOfCards cards from top
	 * 
	 * @param int $numberOfCards
	 */
	public function top(int $numberOfCards) : Cards;
	/**
	 * Return all cards
	 */
	public function all() : Cards;
	/**
	 * Return pile without top $numberOfCards cards
	 * 
	 * @param int $numberOfCards
	 */
	public function drop(int $numberOfCards) : Pile;
	/**
	 * Return pile with all cards removed
	 */
	public function dropAll() : Pile;
	/**
	 * Return pile with $cards on top
	 * 
	 * @param Cards $cards
	 */
	public function add(Cards $cards) : Pile;
	/**
	 * Return pile with top card turned over
	 */
	public function turnTopCard() : Pile;
}
