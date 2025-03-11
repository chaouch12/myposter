<?php

declare(strict_types=1);

namespace Myposter\Production\State;

use Myposter\Production\Article;
use Myposter\Production\Exception\InvalidStateTransferException;
use Myposter\Production\State;

abstract class AbstractState implements StateInterface
{
    protected array $validNextStates = [];
    protected string $name;

    public function getName(): string
    {
        return $this->name;
    }

    public function transitionTo(StateInterface $newState, Article $article): void
    {
        $currentState = $article->getState();

        if (!$currentState->isValidTransition($newState->getType())) {
            throw new InvalidStateTransferException(
                sprintf(
                    'Cannot transition from %s to %s for article type %s',
                    $currentState->getName(),
                    $newState->getName(),
                    $article->getType()
                )
            );
        }

//        $article->setCurrentState($this->createState($newState->getType()));
        $article->setState($newState);
    }

    public function isValidTransition(string $nextState): bool
    {
        return in_array($nextState, $this->validNextStates, true);
    }

    protected function createState(string $state): StateInterface
    {
        $stateMap = [
            State::ORDERED => Ordered::class,
            State::PRINTED => Printed::class,
            State::SLICED => Sliced::class,
            State::FRAMED => Framed::class,
            State::GIFT_WRAPPED => GiftWrapped::class,
            State::SHIPPED => Shipped::class,
        ];

        if (!isset($stateMap[$state])) {
            throw new \InvalidArgumentException("Invalid state: {$state}");
        }

        $stateClass = $stateMap[$state];
        return new $stateClass();
    }
}