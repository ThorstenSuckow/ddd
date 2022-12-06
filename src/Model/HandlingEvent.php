<?php


declare(strict_types=1);

use DateTime;

/**
 * An AGGREGATEROOT representing the handling of a Cargo.
 * 
 * A HandlingEvent is a real world event, not subject to the
 * authority of the domain modeled.
 * 
 * A HandlingEvent can be uniquely identified by the combination of a
 * Cargo's tracking id, a completion time and a HandlingType. 
 * 
 * "A HandlingEvent is a discrete action taken with the Cargo, such as
 * loading it onto a ship or clearing it through customs [...] or being claimed 
 * by the receiver."
 *  - [DDD, Evans, p. 164]
 * "A Handling Event needs to be created in a low-contention transaction -
 * one reason to make it the root of its own AGGREGATE."
 * - [DDD, Evans, p. 171]
 * 
 * 
 * HandlingEvent provides access to CarrierMovement, since the Cargo needs 
 * to be tracked.
 * 
 * 
 */
class HandlingEvent {

    private DateTime $completionTime;

    private HandlingType $type;

    private CarrierMovement $carrierMovement;

    private string $trackingId;

    public function __construct(
        Cargo $cargo,
        CarrierMovement $carrierMovement,
        DateTime $completionTime, 
        HandlingType $type)
    {
        $this->trackingId = $cargo->getTrackingId();
        $this->carrierMovement = $carrierMovement;
        $this->completionTime = $completionTime;
        $this->type = $type;    
    }


}
