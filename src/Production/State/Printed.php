<?php

declare(strict_types=1);

namespace Myposter\Production\State;

use Myposter\Production\State;

final class Printed extends AbstractState
{
	public const TYPE = 'printed';

    public function __construct()
    {
        $this->name = self::TYPE;
        $this->validNextStates = [State::SLICED, State::GIFT_WRAPPED, State::SHIPPED];
    }

	public function getType(): string
	{
		return self::TYPE;
	}
}
