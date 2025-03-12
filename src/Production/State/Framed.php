<?php

declare(strict_types=1);

namespace Myposter\Production\State;

use Myposter\Production\State;

final class Framed implements StateInterface
{
	public const TYPE = 'framed';

	public function getType(): string
	{
		return self::TYPE;
	}
}
