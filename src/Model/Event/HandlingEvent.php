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
 * "The Handling Event in the model is an abstraction that might encapsulate a variety
 * of specialized Handling Event classes, ranging from loading and unloading to sealing,
 * storing, and other activities not related to Carriers."
 * - [DDD, Evans, p. 176]
 * 
 */
class HandlingEvent {

    private DateTime $completionTime;

    private HandlingType $type;

    private string $trackingId;

    /**
     * "By adding FACTORY METHODS to the base class (Handling Event)
     * for each type, instance creation is abstracted, freeing the client 
     * from knowledge of the implementation."
     * - [DDD, Evans, p. 176] 
     */

    /**
     * Creates a new CarrierEvent with the HandlingType LOADING.
     * 
     * @return CarrierEvent The created event.
     */
    public static function newLoading(
        Cargo $cargo,
        DateTime $completionTime,
        CarrierMovement $carrierMovement,
    ): CarrierEvent {

        $event = new CarrierEvent(
            $cargo, 
            $completionTime, 
            HandlingType::LOADING,
            $carrierMovement
        );
        
        $cargo->addHandlingEvent($event);

        return $event;
    }



    /**
     * Constructor.
     * 
     * @param Cargo $cargo
     * @param DateTime $completionTime
     * @param HandlingType $type;
     * 
     * @see "Nonidentifying attributes of an ENTITY can usually be added
     * later. In this case, all attributes of the Handling Event are going 
     * to be set in the initial transaction and never altered [...]"
     * - [DDD, Evans, p. 175] 
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

    public function getTrackingId(): string
    {
        return $this->trackingId;
    }
}
