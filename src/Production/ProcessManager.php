<?php

declare(strict_types=1);

namespace Myposter\Production;

use Myposter\Production\Exception\InvalidStateTransferException;
use Myposter\Production\State\StateInterface;

final class ProcessManager
{
	/**
	 * Confirm whether the given state is valid for the article.
	 * If the state is a valid next state, move the article to the new state.
	 * @throws InvalidStateTransferException
	 */
	public function confirmAndMoveToState(StateInterface $state, Article $article): void
	{
        $expectedIndex = array_search($state->getType(), $article->getAllowedStateTransitions(), true);

        if ($expectedIndex === false || $expectedIndex !== $article->getCurrentStateIndex()) {
            throw new InvalidStateTransferException("Invalid state '{$state->getType()}' for article type '{$article->getType()}'");
        }

        $article->incrementCurrentStateIndex();
	}
}
