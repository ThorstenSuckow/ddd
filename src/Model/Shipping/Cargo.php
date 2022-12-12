<?php

/**
 * DDD
 * Copyright (C) 2022 Thorsten Suckow-Homberg https://github.com/ThorstenSuckow/DDD
 *
 * Permission is hereby granted, free of charge, to any person
 * obtaining a copy of this software and associated documentation
 * files (the "Software"), to deal in the Software without restriction,
 * including without limitation the rights to use, copy, modify, merge,
 * publish, distribute, sublicense, and/or sell copies of the Software,
 * and to permit persons to whom the Software is furnished to do so,
 * subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included
 * in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
 * OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
 * IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM,
 * DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR
 * OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE
 * USE OR OTHER DEALINGS IN THE SOFTWARE.
 */


declare(strict_types=1);

namespace DDD\Model;

use DDD\Exception\CustomerRoleAlreadyExistsException;
use DDD\Exception\UnknownCustomerRoleValueException;

/**
 * AGGREGATEROOT representing a Cargo.
 * A Cargo has a DeliverySpecification which describes the geographical
 * goal of the Cargo.
 * Customers involved with Cargos are identified by qualified associations
 * keyed with the Role (@see CustomerRole) of a Customer.
 * A Cargo can be tracked by quering it's HandlingEvents.
 * Cargos can be uniquely identified with their $trackingId.
 * 
 * @note removed persistent DeliveryHistory
 * @see "The need to update DeliveryHistory when adding a Handling Event
 * gets the Cargo AGGREGATE involved in the transaction. If some other user
 * was modifying Cargo at the same time, the handling Event could fail or
 * be delayed."
 * - [DDD, Evans, p.177] 
 * 
 */
class Cargo {

    /**
     * @var array<Customers>
     */
    private array $customers = []; 

    private ?DeliverySpecification $deliverySpecification = null;

    private CargoType $cargoType;
    
    private string $trackingId;


    /**
     * Constructor.
     * Creates a new Cargo-instance based on the specified $trackingId. 
     */
    public function __construct(string $trackingId, CargoType $cargoType = CargoType::M)
    {
        $this->trackingId = $trackingId;
        $this->cargoType = $cargoType;
    }


    /**
     * Returns the type of the Cargo based on its size.
     */
    public function getCargoType()
    {
        return $this->cargoType;
    }



    /**
     * Adds a new Customer with the CustomerRole to this Cargo.
     * 
     * @throws CustomerRoleAlreadyExistsException if a Customer with the given 
     * CustomerRole already exists
     */
    public function addCustomer (Customer $customer, CustomerRole $role): static
    {
        $roleValue = $role->value;
        if (array_key_exists($roleValue, $this->customers)) {
            throw new CustomerRoleAlreadyExistsException(
                sprintf("\"%s\" already exists as a role with this Cargo", $roleValue)        
            );    
        }

        $this->customers[$roleValue] = $customer;

        return $this;
    }


    /**
     * Change this Cargo's destination.
     * 
     * @see [DDD, Evans, p. 173]
     */
    public function changeDestination (Location $destination)
    {
        $spec = $this->getDeliverySpecification();
        $this->updateDeliverySpecification($spec->setDestination($destination));
    }


    public function getTrackingId()
    {
        return $this->trackingId;
    }


    /**
     * Returns the Customer for the given $role. Returns null
     * if no customer is available for the given $role.
     * 
     * @return Customer|null
     */
    public function getCustomer(CustomerRole $role)
    {
        return $this->customers[$role->value] ?? null;
    }


    /**
     * Returns the Customers as numeric array or an array keyed with their role,
     * depending on $roleKey
     * 
     * @param bool $roleKey true to return an array keyed with the Customer's role
     * 
     * @return array
     */
    public function getCustomers(bool $roleKey = false): array
    {
        if ($roleKey === false) {
            return array_values($this->customers);
        }
        $res = [];
        foreach ($this->customers() as $role => $customer) {
            $res[$role] = $customer;
        }
        return $res;
    }


    /**
     * Returns the Customer's role of this Cargo. 
     * Returns null if the Customer is not affiliated with this
     * Cargo.
     * 
     * @return CustomerRole|null
     * 
     * @throws UnknownCustomerRoleValueException 
     */
    public function getRoleOf(Customer $customer): ?CustomerRole
    {
        foreach ($this->customers as $role => $availCustomer) {
            if ($customer->getCustomerId() === $availCustomer->getCustomerId()) {

                $resolved = CustomerRole::tryFrom($role);

                if (!$resolved) {
                    throw new UnknownCustomerRoleValueException(
                        sprtintf("\"%s\" was not recognized as a valid role.", $role),
                    );
                }

                return $resolved;
            }
        }

        return null;
    }


    public function getDeliverySpecification (): DeliverySpecification 
    {
        return $this->deliverySpecification;
    }


    public function updateDeliverySpecification(DeliverySpecification $deliverySpecification)
    {
        $this->deliverySpecification = $deliverySpecification;
    }


}