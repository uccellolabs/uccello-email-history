<?php

namespace Uccello\EmailHistory\Facades;

use Illuminate\Support\Facades\Facade;

class EmailHistory extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'email-history';
    }
}
