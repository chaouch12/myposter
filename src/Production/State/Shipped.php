<?php

declare(strict_types=1);

namespace Myposter\Production\State;

final class Shipped extends AbstractState
{
	public const TYPE = 'shipped';

    public function __construct()
    {
        $this->validNextStates = [];
    }

	public function getType(): string
	{
		return self::TYPE;
	}
}
