<?php
/*
 * =============================================================================
 *
 * Collabmed Solutions Ltd
 * Project: iClinic
 * Author: KBRAVO <bkiptoo@collabmed.com>
 *
 * =============================================================================
 */
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>LPO-({{ $order['id'] }})<</title>
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
            <div id="project" style="font-size: 90%">
            <h2>PURCHASE ORDER</h2>
                <div><span>SUPPLIER:</span> {{$order->suppliers->name}}</div>
                <div><span>ORDER DATE:</span> {{smart_date($order->created_at)}}</div>
                <div><span>DELIVERY DATE:</span><br>  {{smart_date($order->deliver_date)}}</div>
                <div><span>LPO NUMBER: </span>{{ $order['id'] }}</div>
            </div>
        </header>
        <main>
            <br><br><br><br>
            <table>
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 0;
                    ?>
                    @foreach($order->details as $item)
                    <?php $count+=1; ?>
                    <tr>
                        <td>{{$item->products->name}}</td>
                        <td>{{$item->quantity}}</td>
                        <td>{{number_format($item->price,2)}}</td>
                        <td>{{number_format($item->total,2)}}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <th colspan="2"></th>
                        <th>Total</th>
                        <th>{{$order->totals}}</th>
                    </tr>
                </tbody>
            </table>
            <hr>
    <strong>Signature:</strong><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>

    <br/><br/>
    Payment Confirmed by: <u>{{Auth::user()->profile->full_name}}</u>
        </main>

        <footer>
            <!-- This note was created on a computer and is valid without the signature and seal. -->
        </footer>
    </body>
</html>