<?php
/**
 * integer_net Magento Module
 *
 * @category   IntegerNet
 * @package    IntegerNet
 * @copyright  Copyright (c) 2016 integer_net GmbH (http://www.integer-net.de/)
 * @author     Fabian Schmengler <fs@integer-net.de>
 */

namespace SSE\Cards\Fake;


use DusanKasan\Knapsack\Collection;
use SSE\Cards\Command;
use SSE\Cards\Commands;

class FakeCommands extends \ArrayIterator implements Commands
{
    /**
     * FakeCommands constructor.
     */
    public function __construct(Collection $collection)
    {
        parent::__construct($collection->toArray());
    }
    public static function fromNames(string ...$names)
    {
        return new self(Collection::from($names)
            ->map(function($name) {
                return new FakeCommand($name);
            }));
    }

    public function current() : Command
    {
        return parent::current();
    }

}