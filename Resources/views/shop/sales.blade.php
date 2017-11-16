<div class="row">
    <br/>
    <div class="col-md-12">
        <h4>Items sold today</h4>
        <table width="100%" class="table table-stripped">
            <tbody>
            @foreach($sold as $item)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$item->desc}}</td>
                    <td>KES {{$item->amount}}</td>
                    <td>{{$item->users->profile->name}}</td>
                    <td>{{$item->created_at->format('h:i a')}}</td>
                    <td>
                        <a href="{{route('inventory.receipt',$item->id)}}">
                            <i class="fa fa-eye"></i> View</a>
                        <a target="_blank" href="{{route('inventory.sale.receipt.print',$item->id)}}">
                            <i class="fa fa-print"></i> Print</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
            <thead>
            <tr>
                <th>#</th>
                <th>Description</th>
                <th>Amount</th>
                <th>User</th>
                <th>Time</th>
                <th>Actions</th>
            </tr>
            </thead>
        </table>
    </div>
</div>