<?php

declare(strict_types=1);

namespace Myposter\Production\State;

use Myposter\Production\State;

final class Ordered extends AbstractState
{
	public const TYPE = 'ordered';
    public function __construct()
    {
        $this->name = self::TYPE;
        $this->validNextStates = [State::PRINTED];
    }


	public function getType(): string
	{
		return self::TYPE;
	}
}
