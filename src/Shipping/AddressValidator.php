<?php

declare(strict_types=1);

namespace Myposter\Shipping;

use JsonException;
use Myposter\API\CustomerDataApiMock;
use Myposter\Api\Entity\Customer;
use Myposter\Shipping\Entity\Street;

/**
 * @author Walid Chaouch <walid.chaouch500@gmail.com>
 */
final class AddressValidator
{
    /**
     * @return Customer[]
     * @throws JsonException
     */
	public function getAllCustomers(): array
	{
        $apiData = json_decode(CustomerDataApiMock::getCustomerData(), true, 512, JSON_THROW_ON_ERROR);
        $customers = [];

        foreach ($apiData as $data) {
            $customers[] = new Customer(
                $data['firstName'] ?? '',
                $data['lastName'] ?? '',
                $data['street'] ?? '',
                $data['city'] ?? '',
                $data['postalCode'] ?? ''
            );
        }

        return $customers;
	}

	/**
	 * Split a given street string from a customer into
	 * street name and house number.
	 *
	 * @param Customer $customer
	 * @return Street
	 * @throws \Exception
	 */
	public function splitStreet(Customer $customer): Street
	{
        $streetPattern = '/^(.+?)\s*(\d.*)$/';
        if (preg_match($streetPattern, $customer->getStreet(), $matches)) {
            return new Street($matches[1], $matches[2]);
        }

        return new Street($customer->getStreet(), '');
	}
}
