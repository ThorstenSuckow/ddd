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

use DDD\Model\Location;
use DDD\Repository\HandlingEventRepository;

/**
 * Access past and present handling of a particular Cargo
 */
class TrackingQuery {

    private HandlingEventRepository $handlingEventRepository; 


    public function __construct(HandlingEventRepository $handlingEventRepository)
    {
        $this->handlingEventRepository = $handlingEventRepository;
    }


    /**
     * 
     * @return array<int,HandlingEvent> Sorted in ASCENDING order
     */
    public function getHistoryForTrackingId(string $trackingId)
    {
        return $this->handlingEventRepository->findByTrackindId($trackingId);
    }


    public function getCurrentLocation(string $trackingId): ?Location
    {
        $events = array_reverse($this->getHistoryForTrackingId($trackingId));

        foreach ($events as $event) {
            if ($event->getHandlingType()->involvesCarrier()) {
                return $event->getCarrierMovement()->getDestination();
            }
        }

        return null;
    }

}