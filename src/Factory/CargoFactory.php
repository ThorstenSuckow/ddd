<?php

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
     *   - same DeliverSpecification as the prototype
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

        $deliverySpecification = $prototype->getDeliverySpecification();

        $cargo->updateDeliverySpecification($deliverySpecification);
    
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