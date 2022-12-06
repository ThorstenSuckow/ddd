<?php

declare(strict_types=1);


namespace DDD\Repository;

use DDD\Model\Cargo;
use DDD\Lib\UnitOfWork;

/**
 * Repository for Cargo.
 */
class CargoRepository 
{

    public function findByCargoTrakingId(string $trackingId): ?Cargo
    {

    }

    public function findByCustomerId(string $customerId): ?Cargo
    {

    }


    /**
     * Marks the $cargo as updated if required and returns a UnitOfWork for
     * commiting.
     * 
     * @see "Leave transaction control to the client" [DDD, Evans, p. 156]
     */
    public function save(Cargo $cargo): UnitOfWork
    {
        return new UnitOfWork;

    }


}
