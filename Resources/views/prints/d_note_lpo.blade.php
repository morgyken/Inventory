<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Goods Received Note({{ $order['id'] }})<</title>
        <link rel="stylesheet" href="style.css" media="all" />
 <style>
    body{
        font-weight: bold;
    }
    table{
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    table th{
        border: 1px solid #ddd;
        text-align: left;
        padding: 1px;
        font-size: 90%;
    }

    table tr:nth-child(even){background-color: #f2f2f2}

    table tr:hover {background-color: #ddd;}

    table th{
        padding-top: 1px;
        padding-bottom: 1px;
        background-color: /*#4CAF50*/ #BBBBBB;
        color: black;
        font-size: 90%;
    }
    .left{
        width: 60%;
        float: left;
    }
    .right{
        float: left;
        width: 40%;
    }
    .clear{
        clear: both;
    }
    img{
        width:100%;
        height: auto;
    }
    td{
        font-size: 90%;
    }
    div #footer{
        font-size: 90%;
    }
    th{
        font-size: 90%;
    }
</style>
    </head>
    <body>
        <header class="clearfix">
            <div id="logo">
            </div>
           @include('Inventory::partials.header')
        <h2>GOODS RECIEVED NOTE</h2>
        <br>
            <div id="project">
                <small>SUPPLIER: {{$order->suppliers->name}}</small><br>
                <small>ORDER DATE: {{smart_date($order->created_at)}}</small><br>
                <small>DELIVERY DATE:  {{smart_date($order->deliver_date)}}</small><br>
                <small>DELIVERY NOTE NO: {{$order->id}}</small>
            </div>
        </header>
        <main>
            <br><br>
            <table class="table table-responsive table-striped" >
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Package Size</th>
                        <th>Unit Cost</th>
                        <th>Discount</th>
                        <th>Tax</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($batch->products as $item)
                    <tr>
                        <td>{{$item->products->name}}</td>
                        <td>{{$item->quantity}}</td>
                        <td>{{$item->package_size}}</td>
                        <td>{{number_format($item->unit_cost,2)}}</td>
                        <td>{{number_format($item->discount,2)}}%</td>
                        <td>{{number_format($item->tax,2)}}%</td>
                        <td>{{number_format($item->total,2)}}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="6" style="text-align: right">Total</th>
                        <th>{{number_format($batch->products->sum('total'),2 )}}</th>
                    </tr>
                </tfoot>
            </table>
            <hr/>
    <strong>Signature:</strong><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>

    <br/><br/>
    Payment Confirmed by: <u>{{Auth::user()->profile->full_name}}</u>
        </main>
        <footer>
            <!-- This note was created on a computer and is valid without the signature and seal. -->
        </footer>
    </body>
</html>