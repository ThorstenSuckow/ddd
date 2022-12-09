<?php

declare(strict_types=1);

namespace DDD\Factory;

use DDD\Model\Cargo;
use DDD\Model\Customer;
use DDD\Model\CustomerRole;
use DDD\Model\Location;
use DDD\Model\DeliverySpecification;

/**
 * FACTORY for Cargo. 
 */
class CargoFactory {


    /**
     * Creates a new cargo for the specified Customer and the DeliverySpecification.
     * The Customer will be associated with the CustomerRole "Client".
     * 
     * @param Customer $customer
     * @param DeliverySpecification $deliverySpecification 
     */
    public function createCargo (Customer $customer, DeliverySpecification $deliverySpecification): Cargo
    {
        $cargo = new Cargo($this->generateTrackingId());        
        $cargo->addCustomer($customer, CustomerRole::CLIENT);    
        $cargo->setDeliverySpecification($deliverySpecification);

        return $cargo;
    }


    /**
     * Creates a new Cargo based on the Cargo submitted to this method.
     * The passed Cargo will serve as the prototype for the new Cargo created.
     * The new Cargo will have
     *   - a new $trackingId, 
     *   - same DeliverSpecification as the prototype
     * 
     * @throws MissingCustomerRoleForCargoException if the Cargo serving as a prototype
     * has no CustomerRole "Client" associated with any of its Customers.
     * 
     */
    public function createCargoFrom(Cargo $prototype): Cargo
    {
        $customer = $prototype->getCustomer(CustomerRole::CLIENT); 

        if (!$customer) {
            throw new MissingCustomerRoleForCargoException(
                sprintf(
                    "Cannot create a new Cargo from this Cargo: No Customer available with a " .
                    "\"%s\"-role", CustomerRole::CLIENT->value
                )
            );
        }

        $deliverySpecification = $prototype->getDeliverySpecification();

        return $this->createCargo($customer, $deliverySpecification);
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