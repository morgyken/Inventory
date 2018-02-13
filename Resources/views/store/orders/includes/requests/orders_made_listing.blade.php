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
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $order['name'] }}</td>
                            <td>{{ $order['dispatching'] }}</td>
                            <td>{{ $order['created_at'] }}</td>
                            <td>{{ $order['status'] }}</td>
                            <td>
                                <a href="{{route('inventory.store.show-order', ['storeId' => $store->id, 'orderId' => $order['id']]) }}"
                                   class="btn btn-info btn-xs"> View
                                </a>
                                <a href="{{route('inventory.dispatch.receive-order', ['storeId' => $store->id, 'orderId' => $order['id']]) }}"
                                   class="btn btn-success btn-xs"> Receive
                                </a>

                                @if($order['cancelled'])
                                    <a href="#" class="btn btn-default btn-xs">Cancelled</a>
                                @else
                                    <a href="#" id="{{ $order['id'] }}"
                                            class="btn btn-danger btn-xs cancel-order" data-toggle="modal" data-target="#cancelOrder">
                                        Cancel
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5">No orders made yet</td></tr>
                    @endforelse
                    </tbody>
                </table>

                {{--<div class="pull-right">--}}
                    {{--{{ $orders->links() }}--}}
                {{--</div>--}}
            </div>
        </div>
    </div>

    {{--Cancel Order Modal--}}
    <div id="cancelOrder" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Cancel Order Made<span id="productName"></span></h4>
                </div>
                <div class="modal-body">
                    <form id="adjust-form" action="{{ url('inventory/orders/delete') }}" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" id="order_id" name="order_id" />

                        <div class="form-group">
                            <label for="">Enter Reason for Cancelling Order</label>
                            <textarea cols="30" rows="10" class="form-control" name="cancel_reason" required></textarea>
                        </div>

                        <button class="btn btn-success">Cancel Order</button>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function(){

            $('table').dataTable();

            $("body").on('click', '.cancel-order', function(event){

                var orderId = event.target.id;

                $("#order_id").val(orderId);

            });

        });
    </script>

</div>

