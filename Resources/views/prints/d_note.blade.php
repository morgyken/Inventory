<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Goods Received Note({{ $delivery->id }})<</title>
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
                background-color: #eee;
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
                border-collapse: collapse;
                border-spacing: 0;
                margin-bottom: 20px;
                width:100%;
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
                padding: 10px;
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
            <h1>Goods Received Note:{{ $delivery->id }}</h1><br>
            <div id="company" class="clearfix">
                <div>{{config('practice.name')}}</div>
                <div>{{config('practice.building')}},<br /> {{config('practice.street')}}, {{config('practice.town')}}</div>
                <div>Telephone:{{config('practice.telephone')}}</div>
                <div>Email:<a href="mailto:{{config('practice.email')}}">{{config('practice.email')}}</a></div>
            </div>
            <div id="project">
                <div><span>SUPPLIER</span> {{$delivery->suppliers->name}}</div>
                <div><span>DATE</span> {{smart_date($delivery->created_at)}}</div>
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
                        <td style="text-align: right;" colspan="6" class="grand total">GRAND TOTAL</td>
                        <td class="grand total">{{number_format($delivery->products->sum('total'),2 )}}</td>
                    </tr>
                </tbody>
            </table>
        </main>
        <footer>
            <!-- This note was created on a computer and is valid without the signature and seal. -->
        </footer>
    </body>
</html>