<?php

declare(strict_types=1);

namespace Myposter\API;

final class CustomerDataApiMock
{
	/**
	 * API Mock to simulate an api request to an external service.
	 * The api response is a json string of all customer data.
	 */
	public static function getCustomerData(): string
	{
        $pathToJson = realpath(__DIR__ . '/../../resources/files/customer_data.json');

        if (!file_exists($pathToJson) || !is_readable($pathToJson)) {
            throw new \RuntimeException('File with path "' . $pathToJson . '" does not exist!');
        }

		return \file_get_contents($pathToJson);
	}
}
