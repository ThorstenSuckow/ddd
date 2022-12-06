<?php


declare(strict_types=1);

namespace DDD;


/**
 * Enums representing HandlingTypes, used to identify
 * a HandlingEvent.
 * 
 */
enum HandlingType: string 
{

    case CUSTOMS = "customs";

    case LOADING = "loading";

    case CLAIMED = "claimed";

}