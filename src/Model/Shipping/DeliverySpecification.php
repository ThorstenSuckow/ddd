<?php



namespace DDD;

use DateTime;


/**
 * A representation for a DeliverySpecification.
 * A DeliverySpecification is a VALUEOBJECT that provides information about
 * the required arrival time and the destination of a cargo.
 * A cargo should satisfy its DeliverySpecification. If it won't, it is 
 * probably lost or late.
 * 
 * DeliverySpecifications can be shared among Cargos.
 */
class DeliverySpecification {

    private Location $destination;

    private DateTime $arrivalTime;

    public function __construct (DateTime $arrivalTime, Location $destination) {
        $this->arrivalTime = $arrivalTime;
        $this->destination = $destination;
    }

    public function setArrivalTime(DateTime $arrivalTime): DeliverySpecification {
        return new DeliverySpecification($arrivalTime, $this->getDestination());
    }

    public function setDestination(Location $destination) {
        return new DeliverySpecification ($this->getArrivalTime(), $destination);
    }

    public function getArrivalTime() {
        return $this->arrivalTime;
    }

    public function getDestination() {
        return $this->destination;
    }


}