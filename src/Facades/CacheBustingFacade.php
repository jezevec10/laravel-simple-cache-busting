<?php namespace Ruyter\CacheBusting\Facades;

use Illuminate\Support\Facades\Facade;

class CacheBustingFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'CacheBusting';
    }
}
