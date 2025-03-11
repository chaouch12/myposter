<?php

declare(strict_types=1);

namespace Myposter\Shipping\Entity;

final class Street
{
	public string $name;

	public string $number;

	public function __construct(string $name, string $number)
	{
		$this->name   = $name;
		$this->number = $number;
	}
}
