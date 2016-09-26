<?php ?>
<html lang="en">
    <head>
        <title>Sale Receipt {{$data['sales']->id}} </title>
        <style>
            .clearfix:after {
                content: "";
                display: table;
                clear: both;
            }

            a {
                color: #5D6975;
                text-decoration: underline;
            }

            body {
                position: relative;
                width: 21cm;
                height: 29.7cm;
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
                color: #5D6975;
                font-size: 1.2em;
                line-height: 1.4em;
                font-weight: normal;
                text-align: center;
                margin: 0 0 20px 0;
                background: url(dimension.png);
            }

            #project {
                float: left;
            }

            #project span {
                color: #5D6975;
                text-align: right;
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
                font-weight: normal;
            }

            table .service,
            table .desc {
                text-align: left;
            }

            table td {
                padding: 5px;
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
                color: #5D6975;
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
            <!--
            <div id="logo">
                <img src="logo.png">
            </div>
            -->
            <h1>Sale Receipt ({{$data['sales']->id}})</h1>
            <div id="company" class="clearfix">
                <div>{{config('practice.name')}}</div>
                <div>{{config('practice.building')}},<br /> {{config('practice.street')}}, {{config('practice.town')}}</div>
                <div>Telephone:{{config('practice.telephone')}}</div>
                <div>Email:<a href="mailto:{{config('practice.email')}}">{{config('practice.email')}}</a></div>
            </div>
            <br><br>
            <div id="project">
                <div><span>RECEIPT #:</span> {{$data['sales']->receipt}}</div>
                <div><span>DATE</span> {{ smart_date($data['sales']->created_at) }}</div>
                <div><span>TIME</span>{{smart_time($data['sales']->created_at)}} </div>
                <?php
                if (isset($data['sales']->customer) && $data['sales']->customer !== NULL) {
                    ?>
                    <div><span>Customer</span>{{$data['sales']->customers->first_name.' '.$data['sales']->customers->last_name}} </div>

                <?php } ?>
            </div>
        </header>
        <br><br><br>
        <main>
            <table>
                <thead>
                    <tr>
                        <th></th>
                        <th class="service"><b>ITEM</b></th>
                        <th><b>QTY</b></th>
                        <th><b>DISCOUNT(%)</b></th>
                        <th><b>UNIT COST</b></th>
                        <th><b>TOTAL</b></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['sales']->goodies as $item)
                    <tr>
                        <td></td>
                        <td class="service">{{$item->products->name}}</td>
                        <td class="desc"><center>{{$item->quantity}}</center></td>
                <td class="unit"><center>{{$item->discount}}</center></td>
                <td class="unit"><center>{{number_format($item->unit_cost,2)}}</center></td>
                <td class="total"><center><b>{{number_format($item->total,2)}}</b></center></td>
                </tr>
                @endforeach
                <!--
                                <tr>
                                    <td colspan="4">SUBTOTAL</td>
                                    <td class="total">{{number_format($data['sales']->goodies->sum('total'),2)}}</td>
                                </tr>
                                <tr>
                                    <td colspan="4">TAX</td>
                                    <td class="total">_</td>
                                </tr>-->
                <tr>
                    <td colspan="5" class="grand total">TOTAL</td>
                    <td class="grand total"><center><b><u>{{number_format($data['sales']->goodies->sum('total'),2)}}</u></b></center></td>
                </tr>
                </tbody>
            </table>
            <div id="notices">
                <div class="notice">Service by: <strong>{{$data['sales']->users->profile->full_name}}</strong><br>
                </div>
            </div>

        </main>
        <footer>
        </footer>
    </body>
</html>