<?php
/**
 * Created by PhpStorm.
 * User: kisiara
 * Date: 13/01/2018
 * Time: 16:09
 */

namespace Ignite\Inventory\Repositories;

use Auth;
use Ignite\Inventory\Entities\InternalOrder;
use Ignite\Inventory\Entities\InternalOrderDetails;
use Ignite\Inventory\Entities\InternalOrderDispatch;

class DispatchesRepository
{
    public function dispatch()
    {
        $dispatches = [];

        foreach(request('dispatch') as $dispatch)
        {
            $dispatch['created_at'] = $dispatch['updated_at'] = now();

            array_push($dispatches, $dispatch);
        }

        InternalOrderDispatch::insert(request('dispatch'));
    }
}