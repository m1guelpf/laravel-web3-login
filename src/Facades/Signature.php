<?php

namespace M1guelpf\Web3Login\Facades;

use Illuminate\Support\Facades\Facade;
use M1guelpf\Web3Login\Signature as BaseClass;

class Signature extends Facade
{
    public static function getFacadeAccessor()
    {
        return BaseClass::class;
    }
}
