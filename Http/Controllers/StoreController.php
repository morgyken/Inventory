<?php

namespace Ignite\Inventory\Http\Controllers;

use Ignite\Core\Http\Controllers\AdminBaseController;
use Ignite\Inventory\Repositories\StoresRepository;
use Ignite\Inventory\Repositories\StoreDepartmentsRepository;
use Ignite\Inventory\Http\Requests\StoreRequest;

class StoreController extends AdminBaseController
{
    protected $repo, $departmentsRepo;

    /*
     * Inject dependencies into the class
     */
    public function __construct(StoresRepository $repo, StoreDepartmentsRepository $departmentsRepo)
    {
        parent::__construct();

        $this->repo = $repo;

        $this->departmentsRepo = $departmentsRepo;
    }

    /*
    * Lists all the stores as well as the creation of one
    */
    public function index()
    {
        $stores = $this->repo->all();

        $departments = $this->departmentsRepo->all();

        return view('inventory::store.index', compact('stores', 'departments'));
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

        $departments = $this->departmentsRepo->all();

        return view('inventory::store.edit', compact('stores', 'store', 'departments'));
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
     * Update a store
     */
    public function update($id)
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
