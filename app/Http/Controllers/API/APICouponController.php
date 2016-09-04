<?php

namespace App\Http\Controllers\API;

use App\Factories\CouponFactory;

class APICouponController extends AbstractController
{
    function __construct(CouponFactory $factory) {
        $this->factory = $factory;
    }
}
