<?php

declare(strict_types=1);


namespace DDD\Repository;

use DDD\Model\Customer;

/**
 * Repository for Customer.
 */
class CustomerRepository 
{

    public function findByCustomerId(string $customerId): ?Customer
    {

    }

    public function findByName(string $name): ?array
    {

    }


    public function findByCargoTrackingId(string $trackingId): ?array
    {

    }

}
