<?php

declare(strict_types=1);

namespace Myposter\Production;

use Myposter\Logger\LoggerInterface;
use Myposter\Production\Exception\InvalidStateTransferException;
use Myposter\Production\State\StateInterface;

/**
 * @author Walid Chaouch <walid.chaouch500@gmail.com>
 */
final class ProcessManager
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

	/**
	 * Confirm whether the given state is valid for the article.
	 * If the state is a valid next state, move the article to the new state.
	 * @throws InvalidStateTransferException
	 */
	public function confirmAndMoveToState(StateInterface $state, Article $article): void
	{
        $expectedIndex = array_search($state->getType(), $article->getAllowedStateTransitions(), true);
        $articleName = $article->getType();
        $stateType = $state->getType();

        if ($article->hasGiftWrapping()) {
            $this->logger->info("Article $articleName has gift wrapping.");
        }

        $this->logger->debug("Article $articleName with state $stateType is being processed");

        if ($expectedIndex === false || $expectedIndex !== $article->getCurrentStateIndex()) {

            $exception = new InvalidStateTransferException("Invalid state '{$state->getType()}' for article type '{$article->getType()}'");;
            $this->logger->error($exception->getMessage(), ['exception' => $exception]);
            throw $exception;
        }

        $this->logger->debug("Article $articleName with state $stateType is successfully processed");

        $article->incrementCurrentStateIndex();
	}
}
