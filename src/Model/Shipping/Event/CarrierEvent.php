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

namespace DDD\Model\Event;

use DateTime;
use DDD\Model\CarrierMovement;


/**
 * A specialized HandlingEvent that's associated with a Carrier(Movement).
 * 
 * HandlingEvent provides access to CarrierMovement, since the Cargo needs 
 * to be tracked when Carriers are involved..
 * 
 * 
 */
class CarrierEvent extends HandlingEvent {

    private CarrierMovement $carrierMovement;

    
    public function __construct(
        string $trackingId,
        DateTime $completionTime, 
        HandlingType $type,
        CarrierMovement $carrierMovement

    ) {
        parent::__construct($trackingId, $completionTime, $type);
        $this->carrierMovement = $carrierMovement;
    }


    public function getCarrierMovement(): CarrierMovement
    {
        return $this->carrierMovement;
    }

}