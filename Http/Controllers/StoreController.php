<?php

namespace Ignite\Inventory\Http\Controllers;

use Ignite\Core\Http\Controllers\AdminBaseController;
use Ignite\Inventory\Repositories\StoresRepository;
use Ignite\Inventory\Http\Requests\StoreRequest;

class StoreController extends AdminBaseController
{
    protected $repo;

    /*
     * Inject dependencies into the class
     */
    public function __construct(StoresRepository $repo)
    {
        parent::__construct();

        $this->repo = $repo;
    }

    /*
    * Lists all the stores as well as the creation of one
    */
    public function index()
    {
        $stores = $this->repo->all();

        return view('inventory::store.index', compact('stores'));
    }

    /*
     * Persist a store into the database
     */
    public function store(StoreRequest $request)
    {
        $this->repo->create();

        flash('Store saved', 'success');

        return redirect()->back();
    }

    /*
    * Lists all the stores as well as the creation of one
    */
    public function edit($id)
    {
        $stores = $this->repo->all();

        $store = $stores->find($id);

        return view('inventory::store.edit', compact('stores', 'store'));
    }

    /*
    * Lists all the stores as well as the creation of one
    */
    public function show($id)
    {
        $store = $this->repo->find($id);

        return view('inventory::store.show', compact('store'));
    }


    /*
     * Persist a store into the database
     */
    public function update($id, StoreRequest $request)
    {
        $this->repo->update($id);

        flash('Store updated', 'success');

        return redirect()->back();
    }

    /*
     * Persist a store into the database
     */
    public function delete($id)
    {
        $this->repo->delete($id);

        flash('Store deleted successfully', 'info');

        return redirect()->route('inventory.store.index');
    }
}
