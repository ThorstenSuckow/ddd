<?php


declare(strict_types=1);

use DateTime;

/**
 * An ENTITY representing the handling of a Cargo.
 * 
 * A handlingEvent can be uniquely identified by the combination of Cargo ID
 * completion time and type. 
 * 
 * "A HandlingEvent is a discrete action taken with the Cargo, such as
 * loading, it onto a ship or clearing it through customs [...] or being claimed 
 * by the receiver."
 *  - [DDD, Evans, p. 164]
 * 
 * 
 */
class HandlingEvent {

    private DateTime $completionTime;

    private HandlingType $type;

    private CarrierMovement $carrierMovement;

    private string $cargoId;

    public function __construct(
        Cargo $cargo,
        CarrierMovement $carrierMovement,
        DateTime $completionTime, 
        HandlingType $type)
    {
        $this->cargoId = $cargo->getId();
        $this->carrierMovement = $carrierMovement;
        $this->completionTime = $completionTime;
        $this->type = $type;    
    }


}
