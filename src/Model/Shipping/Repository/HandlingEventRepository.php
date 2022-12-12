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


namespace DDD\Repository;

use DDD\Model\Event\HandlingEvent;
use DDD\Model\Event\HandlingType;
use DateTime;
use DDD\Lib\UnitofWork;

/**
 * Repository for HandlingEvent.
 * 
 * @see "To take responsibility for the queries, we'll add a REPOSITORY
 * for Handling Events. The Handling Event Repository will support 
 * a query for the Events related to a certain Cargo. In addition,
 * the REPOSITORY can provide queries optimized, to answer specific
 * questions efficiently."
 * - [DDD, Evans, p. 177]
 * 
 */
class HandlingEventRepository 
{

    public function findByTrackingIdTimeType(
        string $trackingId, 
        DateTime $time, 
        HandlingType $type
    ): array
    {
        return [];
    }

    public function addHandlingEvent(HandlingEvent $event): UnitOfWork
    {
        return new UnitofWork; // null on error
    }

    /**
     * Sorted by completion_time in ASCENDING order.
     */
    public function findByTrackingId(string $trackingId): array
    {
        return [];
    }


    public function findByScheduleId(string $schdeduleId): array
    {
        return [];
    }


    public function findMostRecentTrackingIdType(
        string $trackingId, 
        HandlingType $type
    ): array {
        return [];
    }


}
