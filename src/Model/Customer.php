<?php

declare(strict_types=1);

namespace DDD\Model;

/**
 * AGGREGATEROOT modelling a Customer, representing a person or a company.
 * The concept of a Customer is not specific to Cargo.
 */
class Customer {

    private string $customerId;


    /**
     * Returns the $customerId.
     * 
     * @return string
     */
    public function getCustomerId(): string
    {
        return $this->customerId;
    }


} 