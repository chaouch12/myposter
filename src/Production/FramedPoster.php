<?php

declare(strict_types=1);

namespace Myposter\Production;

use Myposter\Production\State\StateInterface;

class FramedPoster extends Article
{
    public function __construct(StateInterface $initialState)
    {
        parent::__construct(self::TYPE_POSTER_FRAMED, $initialState);
    }

    protected function initializeStates(): void
    {
        $this->stateTransitions = [
            State::ORDERED,
            State::PRINTED,
            State::SLICED,
            State::FRAMED
        ];

        if ($this->hasGiftWrapping()) {
            $this->stateTransitions[] = State::GIFT_WRAPPED;
        }

        $this->stateTransitions[] = State::SHIPPED;
    }
} 