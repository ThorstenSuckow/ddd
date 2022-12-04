<?php


namespace DDD;

/**
 * ENTITY representing a geographical Location.
 * 
 */
class Location {

    private $portCode;

    public function __construct ($portCode) {
        $this->portCode = $portCode; 
    }

}