<?php
namespace SSE\Cards;

/**
 * Decorator to add callbacks
 */
final class MoveWithCallbacks implements Move
{
	/**
	 * @var Move
	 */
	private $move;
	/**
	 * @var callable
	 */
	private $onSuccess;
	/**
	 * @var callable
	 */
	private $onCancel;
	
	public function __construct(Move $move, callable $onSuccess, callable $onCancel)
	{
		$this->move = $move;
		$this->onSuccess = $onSuccess;
		$this->onCancel = $onCancel;
	}

	public function cards() : Cards
	{
		return $this->move->cards();
	}
	
	public function to(MoveTarget $target) : Event
	{
		try {
			$event = $this->move->to($target);;
		} catch (\Exception $e) {
			\call_user_func($this->onCancel);
			throw $e;
		}
		\call_user_func($this->onSuccess);
		return $event;
	}
}