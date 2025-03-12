<?php

declare(strict_types=1);

namespace Myposter\Production\State;

use Myposter\Production\Article;
use Myposter\Production\Exception\InvalidStateTransferException;

abstract class AbstractState implements StateInterface
{
    protected array $validNextStates = [];

    public function transitionTo(StateInterface $newState, Article $article): void
    {
        if (!$this->isValidTransition($newState, $article)) {
            throw new InvalidStateTransferException(
                sprintf(
                    'Cannot transition from %s to %s for article type %s',
                    $this->getType(),
                    $newState->getType(),
                    $article->getType()
                )
            );
        }

        $article->setState($newState);
    }

    public function isValidTransition(StateInterface $newState, Article $article): bool
    {
        $transitions = $article->getStateTransitions();

        $currentState = $article->getState()->getType();
        $currentPos = array_search($currentState, $transitions, true);

        if ($currentPos === false) {
            error_log("Current state $currentState not found in transitions");
            return false;
        }

        $newPos = array_search($newState->getType(), $transitions, true);

        if ($newPos === false) {
            error_log("New state " . $newState->getType() . " not found in transitions");
            return false;
        }

        // Check if new state comes directly after current state
        $isValid = $newPos === $currentPos + 1;

        if (!$isValid) {
            error_log("Invalid transition from $currentState to " . $newState->getType());
        }
        return $isValid;
    }
}