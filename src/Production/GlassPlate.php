<?php

declare(strict_types=1);

namespace Myposter\Production;

use Myposter\Production\State\StateInterface;

class GlassPlate extends Article
{
    public function __construct(StateInterface $initialState)
    {
        parent::__construct(self::TYPE_PRINTED_GLASS, $initialState);
    }

    protected function initializeStates(): void
    {
        $this->stateTransitions = [
            State::ORDERED,
            State::PRINTED
        ];

        if ($this->hasGiftWrapping()) {
            $this->stateTransitions[] = State::GIFT_WRAPPED;
        }

        $this->stateTransitions[] = State::SHIPPED;
    }
} 