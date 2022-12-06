<?php


namespace DDD;

/**
 * AGGREGATEROOT representing a geographical Location.
 * 
 */
class Location {

    private $portCode;

    public function __construct ($portCode) {
        $this->portCode = $portCode; 
    }

}