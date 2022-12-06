<?php


declare(strict_types=1);

namespace DDD;


/**
 * Delivery History is an ENTITY and a collection of HandlingEvents that
 * occur during the lifetime of a cargo until its DeliverySpecification
 * is satisfied. 
 * 
 * A DeliveryHistory is identified by the owning Cargo.
 */
class DeliveryHistory {

    private string $cargoId;

    private array $handlingEvents = [];


    public function __construct(Cargo $cargo) 
    {
        $this->cargoId = $cargo->getId();
    }


    /**
     * Adds a new HandlingEvent to this collection. Will assume
     * that the event is the latest that occured and push it on top
     * of the event-stack. 
     *
     * @param HandlingEvent $event
     */
    public function addHandlingEvent(HandlingEvent $event)
    {
        $this->handlingEvents[] = $event;
    }


    public function getHandlingEvents(): array
    {
        return $this->handlingEvents;
    }


    /**
     * Returns the latest event that was recorded with this DeliveryHistory.
     * 
     * Returns null if no events were recorded yet.
     */
    public function getNewestEvent(): ?HandlingEvent
    {
        $num = count($this->handlingEvents);

        if (!$num){
            return null;
        } 
        return $this->handlingEvents[$num - 1];
    }



}