<?php


namespace Azarbahram\Captcha\Facades;

use Illuminate\Support\Facades\Facade;

class Azbr extends Facade{

    protected static function getFacadeAccessor()
    {
        return 'azbr'; 
    }

}