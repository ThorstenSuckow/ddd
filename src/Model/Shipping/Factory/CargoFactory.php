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

namespace DDD\Factory;

use DDD\Model\Cargo;
use DDD\Model\Customer;
use DDD\Model\CustomerRole;
use DDD\Model\Location;
use DDD\Model\DeliverySpecification;
use UnknownCustomerRoleValueException;

/**
 * FACTORY for Cargo. 
 */
class CargoFactory {


    /**
     * Creates a new Cargo based on the Cargo submitted to this method.
     * The passed Cargo will serve as the prototype for the new Cargo created.
     * The new Cargo will have
     *   - a new $trackingId, 
     *   - all Customers with their same roles as the $prototype
     *
     * @throws UnknowCustomerRoleValueException if any role of the existing Customers
     * of the prototype-cargo could not be resolved to a CustomerRole 
     */
    public function createCargoFrom(Cargo $prototype): Cargo
    {
        $cargo = new Cargo($this->generateTrackingId());

        $customers = $prototype->getCustomers(); 

        foreach ($customers as $role => $customer) {

            $roleObj = CustomerRole::tryFrom($role);
            if ($roleObj === null) {
                throw new UnknownCustomerRoleValueException(
                    sprintf("\"%s\" could not be mapped to an existing CustomerRole", $role)        
                );
            }

            $cargo->addCustomer($customer, $role);        
        }

        return $cargo;
    }


    /**
     * Creates a new trackingId for Cargo.
     * 
     * @return string
     */
    public function generateTrackingId(): string
    {
        return uniqid();
    }



}