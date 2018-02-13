<div class="panel panel-info">
    <div class="panel-heading">Orders Received</div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-responsive table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Ordered By</th>
                            <th>Requesting Store</th>
                            <th>Ordered date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $order['name'] }}</td>
                            <td>{{ $order['requesting'] }}</td>
                            <td>{{ $order['created_at'] }}</td>
                            <td>{{ $order['status'] }}</td>
                            <td>
                                <a href="{{ route('inventory.dispatch.index',  ['storeId' => $order['dispatching'], 'orderId' => $order['id']]) }}"
                                   class="btn btn-info btn-xs"><i class="fa fa-wrench"></i> Dispatch
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5">No orders received yet</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(function(){
                $('.table').dataTable();
            });
        </script>
    </div>
</div>

