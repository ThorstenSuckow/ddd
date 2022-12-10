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

use DDD\Repository\Cargo;
use DDD\Repository\HandlingEventRepository;
use DDD\Model\Customer;
use DDD\Model\DeliverySpecification;


/**
 * Register new Cargo and prepare the system for it.
 */
class BookingApplication {

    private CargoFactory $cargoFactory;

    private CargoRepository $cargoRepository;

    private TrackingQuery $trackingQuery;
    
    
    public function __construct(
        CargoFactory $cargoFactory, 
        CargoRepository $cargoRepository,
        TrackingQuery $trackingQuery
    ) {
        $this->cargoFactory = $cargoFactory;
        $this->cargoRepository = $cargoRepository;        
        $this->trackingQuery = $trackingQuery;
    }

    
    public function registerNewCargo(Customer $customer, DeliverySpecification $deliverySpecification): Cargo
    {

    }


    /**
     * Returns a list of Cargos associated with the Customer.
     * 
     */
    public function listCargosForCustomer (Customer $customer): array
    {
        return $this->cargoRepository->findByCustomerId($customer->getId());
    }


    /**
     * Change the destination of an existing Cargo.
     * 
     * @see "Sample Application Feature: Changing the Destination of A Cargo"
     * [DDD, Evans, p.173]
     */
    public function changeDestination(Cargo $cargo, Location $newDestination)
    {
        $cargo->changeDestination($newDestination);

        /**
         * The repository returns a uow we have to take care of.
         * @see "Leave transaction control to the client" [DDD, Evans, p.156 ]
         */
        $uow = $this->cargoRepository->save($cargo);
        $uow->commit();
    }


    /**
     * Creates a new Cargo for a given Customer based on an existing one,
     * since same-Customer Cargos are often similar.
     * The user selects a Cargo of a Customer in a list, then picks the one
     * that should be used as the Prototype for the new Cargo.   
     * 
     * @param Cargo $cargoPrototype The existing Cargo that should server as the prototype
     * for the new Cargo that gets created. 
     * 
     * @see "Sample Application Feature: Repeat Business"
     * [DDD, Evans, p.173]
     */
    public function createNewCargoFrom(Cargo $cargoPrototype): Cargo
    {
        return $this->cargoFactory->createCargoFrom($cargoPrototype);        
    }


    public function getCurrentLocation(cargo $cargo): ?Location
    {
        return $this->trackingQuery->getLocationFor($cargo->getTrackingId());

    }

}