<?php

declare(strict_types=1);

namespace Myposter\Production\State;

use Myposter\Production\State;

final class Framed extends AbstractState
{
	public const TYPE = 'framed';

    public function __construct()
    {
        $this->name = self::TYPE;
        $this->validNextStates = [State::GIFT_WRAPPED, State::SHIPPED];
    }

	public function getType(): string
	{
		return self::TYPE;
	}
}
