<?php

namespace App\Http\Controllers\API;

use App\Factories\ProductFactory;

class APIProductController extends AbstractController
{
    function __construct(ProductFactory $factory) {
        $this->factory = $factory;
    }
}
