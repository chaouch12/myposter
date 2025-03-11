<?php

declare(strict_types=1);

namespace Myposter\Production\State;

final class Sliced implements StateInterface
{
	public const TYPE = 'sliced';

	public function getType(): string
	{
		return self::TYPE;
	}
}
