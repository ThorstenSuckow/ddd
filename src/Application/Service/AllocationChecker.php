<?php

declare(strict_types=1);

namespace DDD\Service;


/**
 * Service / Integration Gateway (acting as an ANTI CORRUPTION LAYER) for translating
 * requests from the Shipping System to the Sales Management System, which
 * is another application not within the Boundaries of **this** application.
 * 
 * @see "The Sales Management System was not writtem with the same model in mind
 * that we are working with here. [...] create another class whose job it will be
 * to translate between our model and the language of the Sales Management System.
 * [...] It will expose just the features our application needs, and it will 
 * reabstract them in terms of our domain model."
 * [DDD, Evans, p. 182]
 * 
 */
class AllocationChecker 
{

    public function estimateBookingCount(CargoType $type)
    {


    }


}