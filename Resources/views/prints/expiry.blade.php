<?php
$today = (new \DateTime())->format('Y-m-d');
?>
<html lang="en">
    <head>
        <title>Item Expiry Report </title>
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
                background: url(dimension.png);
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
            <!--
            <div id="logo">
                <img src="logo.png">
            </div>
            -->
            <h1>
                Item Expiry Date Report
            </h1>
            <div id="company" class="clearfix">
                <div>{{config('practice.name')}}</div>
                <div>{{config('practice.building')}},<br /> {{config('practice.street')}}, {{config('practice.town')}}</div>
                <div>Telephone:{{config('practice.telephone')}}</div>
                <div>Email:<a href="mailto:{{config('practice.email')}}">{{config('practice.email')}}</a></div>
            </div>
        </header>
        @if(!$data->isEmpty())
        <div class="box-body">
            <h4>
                @if($info->scope)

                @if($info->scope === 'null')
                Showing all item expiry dates
                @else
                Items expiring in {{$info->scope}} month's time.
                @endif
                @elseif($info->start && $info->end)
                Items expiring between {{$info->start}} and {{$info->end}}
                @endif
            </h4>
            <table id="cashier" class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Item</th>
                        <th>Batch</th>
                        <th>Arrival Date</th>
                        <th>Units in Store</th>
                        <th>Expiry Date</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $n = 0; ?>
                    @foreach($data as $record)
                    <tr>
                        <td>{{$n+=1}}</td>
                        <td>{{$record->products->name}}
                            @if($record->products->strength)
                            {{$record->products->strength}} {{$record->products->units->name}}
                            @endif
                        </td>
                        <td>{{$record->batch}}</td>
                        <td>{{(new Date($record->created_at))->format('jS M Y')}}</td>
                        <td>{{$record->remaining}}</td>
                        <td>
                            {{(new Date($record->expiry_date))->format('jS M Y')}}
                        </td>
                        <td>
                            @if($record->expiry_date < $today)
                            <span style="color: red">
                                <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>Expired
                                {{\Carbon\Carbon::createFromTimeStamp(strtotime($record->expiry_date))->diffForHumans() }}
                            </span>
                            @else
                            <span style="color: green"><i class="fa fa-circle-o-notch fa-spin"></i>
                                {{ \Carbon\Carbon::createFromTimeStamp(strtotime($record->expiry_date))->diffForHumans()}}
                            </span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="alert alert-info">
            <p>No expiry dates yet!</p>
        </div>
        @endif

        <footer>
        </footer>
    </body>
</html>