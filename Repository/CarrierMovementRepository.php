<?php

declare(strict_types=1);


namespace DDD\Repository;

use DDD\Location;
use DDD\Model\Carriermovement;

/**
 * Repository for CarrierMovement.
 */
class CarrierMovementRepository 
{

    public function findByScheduleId(string $scheduleId): ?CarrierMovement
    {

    }

    public function findByFromToDestination(Location $from, Location $destination): ?array
    {

    }

}
