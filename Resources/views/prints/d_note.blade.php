<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Goods Received Note({{ $delivery->id }})<</title>
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
            <h2>Goods Recieved Notes</h2>
            <div id="project">
                <div><span>SUPPLIER</span> {{$delivery->suppliers->name}}</div>
                <div><span>DATE</span> {{smart_date($delivery->created_at)}}</div>
                <div><span>Good Received Note No:</span> {{ $delivery->id }}</div>
            </div>
        </header>
        <main>
            <br><br><br><br>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th style="text-align: left;">Item</th>
                        <th>Quantity</th>
                        <th>Package Size</th>
                        <th>Price</th>
                        <th>Discount(%)</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 0;
                    ?>
                    @foreach($delivery->products as $item)
                    <tr class="products">
                        <td>{{$count+=1}}</td>
                        <td style="text-align: left;">{{$item->products->name}}</td>
                        <td>{{$item->quantity}}</td>
                        <td>{{$item->package_size}}</td>
                        <td>{{number_format($item->unit_cost,2)}}</td>
                        <td>{{$item->discount}}</td>
                        <td>{{number_format($item->total,2)}}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <th style="text-align: right;" colspan="6" class="grand total">GRAND TOTAL</th>
                        <th class="grand total">{{number_format($delivery->products->sum('total'),2 )}}</th>
                    </tr>
                </tbody>
            </table>
        </main>
        <footer>
            <!-- This note was created on a computer and is valid without the signature and seal. -->
        </footer>
    </body>
</html>