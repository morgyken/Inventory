<div class="panel panel-info">
    <div class="panel-heading">Orders Made</div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                @if($store->main_store)
                    <div>
                        <a class="btn btn-sm btn-primary" href="{{ url('inventory/purchase/direct/goods?store='.$store->id) }}">
                            Receive goods directly from supplier
                        </a>
                    </div>
                @endif

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
                    @forelse($store->orders->sortByDesc('created_at') as $order)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $order->users->profile->fullName }}</td>
                            <td>{{ $order->dispatchingStore->name }}</td>
                            <td>{{ $order->created_at }}</td>
                            <td>
                                <a href="{{route('inventory.show-order', $order->id)}}"
                                   class="btn btn-info btn-xs"> View
                                </a>
                                <a href="{{route('inventory.dispatch.receive-order', ['storeId' => $store->id, 'orderId' => $order->id])}}"
                                   class="btn btn-success btn-xs"> Receive
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