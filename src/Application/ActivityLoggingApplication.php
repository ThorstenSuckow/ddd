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

namespace DDD\Application;

use DateTime;
use DDD\Model\CarrierMovement;
use DDD\Model\HandlingType;

/**
 * Record Cargo-handling.
 * 
 * 
 */
class ActivityLoggingApplication {

    private HandlingEventFactory $handlingEventFactory;


    public function __construct(HandlingEventFactory $handlingEventFactory)
    {
        $this->handlingEventFactory = $handlingEventFactory;
    }
        
    /**
     * Handles the specified data as a event for the given Cargo.
     * 
     * @see "Each time the cargo is handled in the real world, some user will enter
     * a Handling Event using the Incident Logging Application"
     * [DDD, Evans, p. 175]
     */
    public function handleEvent(Cargo $cargo, DateTime $completionTime, HandlingType $type): HandlingEvent
    {
        return $cargo->getDeliveryHistory()->addHandlingEvent($cargo, $completionTime, $type);
    }

    
    /**
     * Logs a new HandlingEvent with the handlingType LOADING.
     * 
     */
    public function handleLoadingEvent(
        Cargo $cargo, 
        DateTime $completionTime, 
        CarrierMovement $carrierMovement
    ): HandlingEvent {
        return $cargo->getDeliveryHistory()->addHandlingEvent(
            $this->handlingEventFactory->createLoadingEvent(
                $cargo, 
                $completionTime, 
                $carrierMovement
            )
        );
    }




}