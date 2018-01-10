<div class="row">
    <div class="col-md-12">
        @if(!$stores->isEmpty())
            <table class="table table-responsive table-striped">
                <tbody>
                @foreach($stores as $store)
                    <tr id="supplier{{$store->id}}">
                        <td>{{$store->id}}</td>
                        <td>{{$store->name}}</td>
                        <td>{{!$store->parentStore ?'': $store->parentStore->name }}</td>
                        <td>{{$store->created_at}}</td>
                        <td>
                            <a href="{{route('inventory.store.edit', $store->id)}}"
                               class="btn btn-primary btn-xs">
                                <i class="fa fa-edit"></i> Edit</a>
                            <a href="{{route('inventory.store.delete', $store->id)}}"
                               class="btn btn-danger btn-xs">
                                <i class="fa fa-trash"></i> Delete</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <thead>
                <tr>
                    <th>Store Id</th>
                    <th>Store Name</th>
                    <th>Parent Store</th>
                    <th>Date Added</th>
                    <th></th>
                </tr>
                </thead>
            </table>
        @else
            <div class="alert alert-info">
                <p>No Store has been created</p>
            </div>
        @endif
    </div>
</div>