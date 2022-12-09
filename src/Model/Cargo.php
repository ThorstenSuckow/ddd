<?php

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
 */
class Cargo {

    /**
     * @var array<Customers>
     */
    private array $customers = []; 

    private ?DeliverySpecification $deliverySpecification = null;

    private DeliveryHistory $deliveryHistory;

    private string $trackingId;


    public function __construct(string $trackingId)
    {
        $this->trackingId = $trackingId;
        $this->deliveryHistory = new DeliveryHistory($this);
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


    /**
     * Adds a new HandlingEvent to this Cargo's DeliveryHistory.
     * If this Cargo does not have a DeliveryHistory yet, it will get implicitly
     * created.
     * 
     * @param HandlingEvent $event
     */
    public function handleEvent(HandlingEvent $event): static
    {
        if (!$this->getDeliveryHistory()) {
            /**
             * @todo can we avoid circular references?
             * "Tracking is core to Cargo in this application. A history must
             * refer to its subject."
             * - [DDD, Evans, p. 170]
             */
            $this->deliveryHistory = new DeliveryHistory($this);
        }

        $this->deliveryHistory->addHandlingEvent($event);
    
        return $this;
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


    /**
     * Returns the current location of this Cargo. If the Cargo has no DeliveryHistory
     * yet, the Location returned will be null.
     *
     * 
     * @return Location|null
     */
    public function getCurrentLocation(): ?Location
    {
        if ($this->getDeliveryHistory()) {
            return null;
        }

        $event = $this->getDeliveryHistory()->getNewestEvent();

        return $event->getCarrierMovement()->getDestination();
    }


    public function getDeliverySpecification (): DeliverySpecification 
    {
        return $this->deliverySpecification;
    }


    public function getDeliveryHistory(): DeliveryHistory
    {
        return $this->deliveryHistory;
    }

    public function setDeliveryHistory(Deliveryhistory $deliveryHistory): static 
    {
        $this->deliveryHistory = $deliveryHistory;
        return $this;
    }


    public function updateDeliverySpecification(DeliverySpecification $deliverySpecification)
    {
        $this->deliverySpecification = $deliverySpecification;
    }


}