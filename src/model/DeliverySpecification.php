<?php



namespace DDD;

use DateTime;


/**
 * A representation for a DeliverySpecification.
 * A DeliverySpecification is a VALUEOBJECT that provides information about
 * the arrival time and the location for a cargo.
 * A cargo should satisfy its DeliverySpecification. If it won't, it is 
 * probably lost or late.
 * 
 * DeliverySpecifications can be shared among Cargos.
 */
class DeliverySpecification {

    private Location $location;

    private DateTime $arrivalTime;

    public function __construct (DateTime $arrivalTime, Location $location) {
        $this->arrivalTime = $arrivalTime;
        $this->location = $location;
    }

    public function setArrivalTime(DateTime $arrivalTime): DeliverySpecification {
        return new DeliverySpecification($arrivalTime, $this->getLocation());
    }

    public function setLocation(Location $location) {
        return new DeliverySpecification ($this->getArrivalTime(), $location);
    }

    public function getArrivalTime() {
        return $this->arrivalTime;
    }

    public function getLocation() {
        return $this->location;
    }

}