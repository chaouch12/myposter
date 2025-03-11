<?php

declare(strict_types=1);

namespace Myposter\Production\State;

use Myposter\Production\State;

final class GiftWrapped extends AbstractState
{
	public const TYPE = 'gift-wrapped';

    public function __construct()
    {
        $this->name = self::TYPE;
        $this->validNextStates = [State::SHIPPED];
    }

	public function getType(): string
	{
		return self::TYPE;
	}
}
