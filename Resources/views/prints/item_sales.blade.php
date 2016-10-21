<!DOCTYPE html>
<html lang="en">
    <?php
    /*
     * Collabmed Solutions Ltd
     * Project: iClinic
     *  Author: KIPTOO BRAVO <bkiptoo@collabmed.com>
     */
    $records = $data['records'];
    $start = Illuminate\Support\Facades\Input::get('start');
    $end = Illuminate\Support\Facades\Input::get('end');
    $n = $total = $amount = 0;
    ?>
    <head>
        <title>Item Sales Summary Report</title>
        <link rel="stylesheet" href="style.css" media="all" />
        <style>
            .clearfix:after {
                content: "";
                display: table;
                clear: both;
            }

            a {
                text-decoration: underline;
            }

            body {
                position: relative;
                margin: 0 auto;
                color: #001028;
                background: #FFFFFF;
                font-family: Arial, sans-serif;
                font-size: 12px;
                font-family: Arial;
            }

            header {
                padding: 10px 0;
                margin-bottom: 30px;
            }

            #logo {
                text-align: center;
                margin-bottom: 10px;
            }

            #logo img {
                width: 90px;
            }

            h1 {
                border-top: 1px solid  #5D6975;
                border-bottom: 1px solid  #5D6975;
                font-size: 2.4em;
                line-height: 1.4em;
                font-weight: normal;
                text-align: center;
                margin: 0 0 20px 0;
                background-color:#eee;
            }

            #project {
                float: left;
            }

            #project span {
                color: #5D6975;
                text-align: left;
                width: 52px;
                margin-right: 10px;
                display: inline-block;
                font-size: 0.8em;
            }

            #company {
                float: right;
                text-align: right;
            }

            #project div,
            #company div {
                white-space: nowrap;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                border-spacing: 0;
                margin-bottom: 20px;
            }

            table tr:nth-child(2n-1) td {
                background: #F5F5F5;
            }

            table th,
            table td {
                text-align: center;
            }

            table th {
                padding: 5px 20px;
                border-bottom: 1px solid #C1CED9;
                white-space: nowrap;
                font-weight: bold;
            }

            table .service,
            table .desc {
                text-align: left;
            }

            table td {
                padding: 10px;
                text-align: center;
            }
            table .sums{
                padding: 20px;
                text-align: right;
            }

            table td.service,
            table td.desc {
                vertical-align: top;
            }

            table td.unit,
            table td.qty,
            table td.total {
                font-size: 1.2em;
            }

            table td.grand {
                border-top: 1px solid #5D6975;;
            }

            #notices .notice {
                font-size: 1.2em;
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
            <div id="logo">
            </div>
            <h1>Item Sales Summary:{{filter_description($data['filter'])}}</h1><br>
            <div id="company" class="clearfix">
                <div>{{config('practice.name')}}</div>
                <div>{{config('practice.building')}},<br /> {{config('practice.street')}}, {{config('practice.town')}}</div>
                <div>Telephone:{{config('practice.telephone')}}</div>
                <div>Email:<a href="mailto:{{config('practice.email')}}">{{config('practice.email')}}</a></div>
            </div>
        </header>
        <main>
            <br><br><br><br>

            <table id="cashier" class="table table-borderless">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Item</th>
                        <th style="text-align: center">Quantity</th>
                        <th style="text-align: center">Price</th>
                        <th style="text-align: center">Amount</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($records as $record)
                    <?php
                    $total = $record->price * $record->quantity;
                    $amount+=$total;
                    ?>
                    <tr>
                        <td>{{$n+=1}}</td>
                        <td>{{$record->products->name}}{{$record->products->strength?'('.$record->products->strength.$record->products->units->name.')':''}}</td>
                        <td style="text-align: center">{{$record->quantity}}</td>
                        <td style="text-align: center">{{$record->price}}</td>
                        <th style="text-align: center">{{number_format($total,2)}}</th>
                        <td>{{(new Date($record->created_at))->format('jS M Y')}}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <th colspan="4" style="text-align: right">Total</th>
                        <th style="text-align: center">{{number_format($amount,2)}}</th>
                        <th></th>
                    </tr>
                </tbody>
            </table>
        </main>
        <footer>
            <!-- This note was created on a computer and is valid without the signature and seal. -->
        </footer>
    </body>
</html>