<?php

declare(strict_types=1);

namespace Myposter\Production\State;

use Myposter\Production\Article;

interface StateInterface
{
	public function getType(): string;
    public function transitionTo(StateInterface $newState, Article $article): void;
    public function isValidTransition(StateInterface $newState, Article $article): bool;

}
