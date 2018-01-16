<div class="panel panel-info">
    <div class="panel-heading">Orders Made</div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-responsive table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Ordered By</th>
                            <th>Dispatching Store</th>
                            <th>Ordered date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($store->orders as $order)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $store->name }}</td>
                            <td>{{ !$store->parentStore ?'': $store->parentStore->name }}</td>
                            <td>{{ $store->created_at }}</td>
                            <td>
                                <a href="{{route('inventory.store.orders-made', $store->id)}}"
                                   class="btn btn-info btn-xs"><i class="fa fa-wrench"></i> View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5">No orders made yet</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
// $(document).ready(function(){
//     $('.table').dataTable();
// });
</script>