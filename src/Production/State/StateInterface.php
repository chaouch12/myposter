<?php

declare(strict_types=1);

namespace Myposter\Production\State;

interface StateInterface
{
	public function getType(): string;
}
