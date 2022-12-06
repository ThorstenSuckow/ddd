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


    public function registerNewCargo(Customer $customer, DeliverySpecification $deliverySpecification): Cargo
    {

    }


    /**
     * 
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


}