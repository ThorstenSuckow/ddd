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

namespace DDD;

USE DDD\Exception\UnexpectedCargoException;

/**
 * Delivery History is an ENTITY and a collection of HandlingEvents that
 * occur during the lifetime of a cargo until its DeliverySpecification
 * is satisfied. 
 * 
 * A DeliveryHistory is identified by the owning Cargo.
 */
class DeliveryHistory {

    /**
     * The tracking id of the Cargo that is subject to this History.
     */
    private string $trackingId;

    private array $handlingEvents = [];


    public function __construct(Cargo $cargo) 
    {
        $this->trackingId = $cargo->getTrackingId();
    }


    /**
     * Adds a new HandlingEvent to this collection. Will assume
     * that the event is the latest that occured and push it on top
     * of the event-stack.
     *
     * @param HandlingEvent $event
     * 
     * @throws UnexpectedCargoException if this Cargo is not equal to the
     * Cargo registered with the HandlingEvent
     * 
     * @see "Transaction coulkd fail because of contention for a_Cargo
     * or its component a_Delivery_History."
     * - [DDD, Evans, p.176]
     */
    public function addHandlingEvent(HandlingEvent $event): static
    {
        if ($event->getTrackingId() !== $this->getTrackingId()) {
            throw new UnexpectedCargoException(
                sprintf(
                    "The tracking-id of the cargo %1s does not match the tracking-id of the event %2s", 
                    $this->getTrackingId(),
                    $event->getTrackingId()
                );
            );
        }

        $this->handlingEvents[] = $event;

        return $this;
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

    public function getTrackingId(): string
    {
        return $this->trackingId;
    }


}