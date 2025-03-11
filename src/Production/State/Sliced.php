<?php

declare(strict_types=1);

namespace Myposter\Production\State;

use Myposter\Production\State;

final class Sliced extends AbstractState
{
	public const TYPE = 'sliced';

    public function __construct()
    {
        $this->name = self::TYPE;
        $this->validNextStates = [State::FRAMED];
    }

	public function getType(): string
	{
		return self::TYPE;
	}
}
