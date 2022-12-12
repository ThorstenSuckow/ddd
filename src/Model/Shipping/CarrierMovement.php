<?php



declare(strict_types=1);

namespace DDD\Model;


/**
 * AGGREGATEROOT representing the movememnt of Cargo
 * from one destination to another.
 * CarrierMovements can be identified by their $scheduleId.
 * 
 */
class CarrierMovement 
{

    private string $scheduleId;

    private Location $from;

    private Location $destination;


    public function __construct($scheduleId, Location $from, Location $destination)
    {
        $this->scheduleId = $scheduleId;
        $this->from = $from;
        $this->destination = $destination;
    }



    public function getDestination () 
    {
        return $this->destination;
    }

}