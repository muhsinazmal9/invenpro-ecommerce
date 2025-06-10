<?php

namespace App\Traits;

trait DefaultRouteKey
{
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
