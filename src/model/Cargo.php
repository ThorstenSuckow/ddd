<?php

declare(strict_types=1);

namespace DDD;


/**
 * AGGREGATEROOT representing a Cargo.
 * A Cargo has a DeliverySpecification which describes the goal of
 * the Cargo.
 * 
 */
class Cargo {


    private ?DeliverySpecification $deliverySpecification = null;

    private ?DeliveryHistroy $deliveryHistory = null;

    private int $cargoId;

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
            $this->deliveryHistory = new DeliveryHistory($this);
        }

        $this->deliveryHistory->addHandlingEvent($event);
    
        return $this;
    } 


    /**
     * Returns the current location of this Cargo. If the Cargo has no DeliveryHistory
     * yet, the Location returned will be null.
     *
     * 
     * @return ?Location
     */
    public function getCurrentLocation(): ?Location
    {
        if ($this->getDeliveryHistory()) {
            return null;
        }

        $event = $this->getDeliveryHistory()->getNewestEvent();

        return $event->getCarrierMovement()->getLocation();
    }


    public function setDeliverySpecification (DeliverySpecification $deliverySpecification): static 
    {
        $this->deliverySpecification = $deliverySpecification;
        return $this;
    }

    public function getDeliverySpecification (): ?DeliverySpecification 
    {
        return $this->deliverySpecification;
    }


    public function getDeliveryHistory(): ?DeliveryHistory
    {
        return $this->deliveryHistory;
    }


}