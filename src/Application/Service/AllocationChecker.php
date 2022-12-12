<?php

/**
 * DDD
 * Copyright (C) 2022 Thorsten Suckow-Homberg https://github.com/ThorstenSuckow/DDD
 *
 * Permission is hereby granted, free of charge, to any person
 * obtaining a copy of this software and associated documentation
 * files (the "Software"), to deal in the Software without restriction,
 * including without limitation the rights to use, copy, modify, merge,
 * publish, distribute, sublicense, and/or sell copies of the Software,
 * and to permit persons to whom the Software is furnished to do so,
 * subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included
 * in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
 * OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
 * IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM,
 * DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR
 * OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE
 * USE OR OTHER DEALINGS IN THE SOFTWARE.
 */


declare(strict_types=1);

namespace DDD\Service;

use DDD\Cargo\EnterpriseSegment;

/**
 * Encapsulates Sales Management System.
 * 
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
 *  @see "The Allocation Checker will translate between Enterprise Segments and the 
 * category names of the external system."
 * [DDD, Evans, p. 184]
 * 
 */
class AllocationChecker 
{

    public function allocation (EnterpriseSegment $segment): int
    {
        
    }

}