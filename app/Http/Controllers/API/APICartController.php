<?php

namespace App\Http\Controllers\API;

use App\Factories\CartFactory;

class APICartController extends AbstractController
{
    function __construct(CartFactory $factory) {
        $this->factory = $factory;
    }
}
