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

    /**
     * A HandlingEvent might have 1 or 0 CarrierMovements.
     */
    private ?CarrierMovement $carrierMovement = null;

    private string $trackingId;


    /**
     * Constructor.
     * 
     * @param Cargo $cargo
     * @param DateTime $completionTime
     * @param HandlingType $type;
     * 
     */
    public function __construct(
        Cargo $cargo,
        DateTime $completionTime, 
        HandlingType $type
    ) {
        $this->trackingId = $cargo->getTrackingId();
        $this->completionTime = $completionTime;
        $this->type = $type;    
    }


    public function setCarrierMovement(CarrierMovement $carrierMovement): static 
    {
        $this->carrierMovement = $carrierMovement;
        return $this;
    }


    public function getCarrierMovement(): ?CarrierMovement
    {
        return $this->carrierMovement;
    }
}
