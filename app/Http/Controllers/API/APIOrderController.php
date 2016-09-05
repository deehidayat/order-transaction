<?php

namespace App\Http\Controllers\API;

use App\Factories\OrderFactory;

class APIOrderController extends AbstractController
{
    function __construct(OrderFactory $factory) {
        $this->factory = $factory;
    }
}
