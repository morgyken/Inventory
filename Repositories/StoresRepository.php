<?php
namespace Ignite\Inventory\Repositories;

use DB;
use Ignite\Inventory\Entities\Store;
use Ignite\Inventory\Events\StoreCreated;

class StoresRepository
{
    /*
     * Returns all the definitions of stores from the database
     */
    public function all()
    {
        return Store::with('parentStore')->get();
    }

    /*
     * Create a new store and persist it
     */
    public function create()
    {
        DB::transaction(function () {

            $store = Store::create(request()->all());

//            event(new StoreCreated($store));

            return $store;

        });
    }

    /*
     * Find a single store using its id
     */
    public function find($id)
    {
        return Store::find($id);
    }

    /*
     * Create a new store and persist it
     */
    public function update($id)
    {
        $data = request()->except('_token');

        $data['main_store'] = request()->has('main_store') ? request('main_store') : 0;

        $data['delivery_store'] = request()->has('delivery_store') ? request('delivery_store') : 0;

        Store::where('id', $id)->update($data);
    }

    /*
     * Create a new store and persist it
     */
    public function delete($id)
    {
        Store::destroy($id);
    }


}