<?php ?>
<html lang="en">
    <head>
        <title>Item Stock Report </title>
        <style>
            h1 {
                border-top: 1px solid  #5D6975;
                border-bottom: 1px solid  #5D6975;
                color: #5D6975;
                font-size: 1.2em;
                line-height: 1.4em;
                font-weight: normal;
                text-align: center;
                margin: 0 0 20px 0;
                background: url(dimension.png);
            }

            table td {
                text-align: center;
            }

            table tr:nth-child(2n-1) td {
                background: #eee;
            }

            table th {
                padding: 5px 10px;
                color: #5D6975;
                border-bottom: 1px solid #C1CED9;
                white-space: nowrap;
                font-weight: normal;
            }


            footer {
                width: 100%;
                height: 30px;
                position: absolute;
                bottom: 0;
                border-top: 1px solid #C1CED9;
                padding: 8px 0;
                text-align: center;
            }
        </style>
    </head>
    <body>
        <header class="clearfix">
            <!--
            <div id="logo">
                <img src="logo.png">
            </div>
            -->
            <h1>Item Stock Report</h1>
            <div id="company" class="clearfix">
                <div>{{config('practice.name')}}</div>
                <div>{{config('practice.building')}},<br /> {{config('practice.street')}}, {{config('practice.town')}}</div>
                <div>Telephone:{{config('practice.telephone')}}</div>
                <div>Email:<a href="mailto:{{config('practice.email')}}">{{config('practice.email')}}</a></div>
            </div>
        </header>
        <br><br><br>
        @if(!$data['stocks']->isEmpty())
        <table style="width:100%" class="table table-responsive table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Item Code</th>
                    <th>Item</th>
                    <th>Cost</th>
                    <th>Remaining Stock Items</th>
                    <th>Value</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $n = 0;
                $total_value = 0;
                $sell_value = 0;
                ?>
                @foreach($data['stocks'] as $s)
                <?php
                $price = $s->products->prices->max('price');
                $value = $price * $s->quantity;
                $total_value+=$value;
                ?>
                <tr id="category{{$s->id}}">
                    <td>{{$n+=1}}</td>
                    <td>{{$s->products->id}}</td>
                    <td>{{$s->products->name}}</td>
                    <td>{{number_format($price,2)}}</td>
                    @if($s->quantity<20)
                    <td style="color:red">{{$s->quantity ?$s->quantity :'0'}}</td>
                    @else
                    <td>{{$s->quantity ?$s->quantity: '0'}}</td>
                    @endif
                    <td>{{number_format($value,2)}}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4"></th>
                    <th style="text-align: right">Total Stock Value:</th>
                    <th>{{number_format($total_value,2)}}</th>
                </tr>
            </tfoot>
        </table>
        @else
        <div class="alert alert-info">
            <p>No rocords to show!</p>
        </div>
        @endif

        <footer>
        </footer>
    </body>
</html>