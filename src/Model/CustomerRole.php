<?php

declare(strict_types=1);

namespace DDD\Model;

enum CustomerRole: string 
{

    case SHIPPER = "shipper";

    case RECEIVER = "receiver";

    case PAYER = "payer";

} 