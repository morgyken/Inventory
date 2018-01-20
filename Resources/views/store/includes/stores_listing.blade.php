<div class="panel panel-info">
    <div class="panel-heading">Stores listing</div>

    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-responsive table-striped">
                    <thead>
                    <tr>
                        <th>Store Id</th>
                        <th>Store Name</th>
                        <th>Clinic/Department</th>
                        <th>Parent Store</th>
                        <th>Date Added</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($stores as $store)
                        <tr id="supplier{{$store->id}}">
                            <td>{{$store->id}}</td>
                            <td>{{$store->name}}</td>
                            <td>{{$store->department->name ?? ''}}</td>
                            <td>{{!$store->parentStore ?'': $store->parentStore->name }}</td>
                            <td>{{$store->created_at}}</td>
                            <td>
                                <a href="{{route('inventory.store.orders-made', $store->id)}}"
                                class="btn btn-info btn-xs"><i class="fa fa-wrench"></i> Manage</a>
                                <a href="{{route('inventory.store.edit', $store->id)}}"
                                   class="btn btn-primary btn-xs"><i class="fa fa-edit"></i> Edit</a>
                                <a href="{{route('inventory.store.delete', $store->id)}}"
                                   class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Delete</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td>No data found</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>