<?php


declare(strict_types=1);

namespace DDD\Application;

use DDD\Repository\Cargo;

use DDD\Model\Customer;
use DDD\Model\DeliverySpecification;


/**
 * Register new Cargo and prepare the system for it.
 */
class BookingApplication {

    private CargoFactory $cargoFactory;

    private CargoRepository $cargoRepository;


    public function __construct(
        CargoFactory $cargoFactory, 
        CargoRepository $cargoRepository
    ) {
        $this->cargoFactory = $cargoFactory;
        $this->cargoRepsository = $cargoRepository;        
    }

    
    public function registerNewCargo(Customer $customer, DeliverySpecification $deliverySpecification): Cargo
    {

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

}