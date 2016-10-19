<?php ?>
<html lang="en">
    <head>
        <title>Stock Movement Report </title>
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
            <h1>Stock Movement Report</h1>
            <div id="company" class="clearfix">
                <div>{{config('practice.name')}}</div>
                <div>{{config('practice.building')}},<br /> {{config('practice.street')}}, {{config('practice.town')}}</div>
                <div>Telephone:{{config('practice.telephone')}}</div>
                <div>Email:<a href="mailto:{{config('practice.email')}}">{{config('practice.email')}}</a></div>
            </div>
        </header>
        <br><br><br>

        @if(!$data['adjustments']->isEmpty())
        <table id="table" class="table table-responsive table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Item</th>
                    <th>Opening<br/> Stock</th>
                    <th style="text-align: center">Change</th>
                    <th>Closing<br/> Stock</th>
                    <th>Type</th>
                    <th>By</th>
                    <th>Date</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php $n = 0; ?>
                @foreach($data['adjustments'] as $adj)
                <tr id="category{{$adj->id}}">
                    <td>{{$n+=1}}</td>
                    <td>{{$adj->products->name}}</td>
                    <td>{{$adj->opening_qty}}</td>
                    <td style="text-align: center">
                        {{$adj->quantity}} {{$adj->method=='+'?"In(+)":"Out(-)"}}
                    </td>
                    <td>{{$adj->closing}}</td>
                    <td>{{$adj->type}}</td>
                    <td>{{$adj->users?$adj->users->username:'-'}}</td>
                    <td>{{$adj->created_at}}</td>
                    <td>......................</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="alert alert-info">
            <p>No stock has moved yet!</p>
        </div>
        @endif

        <footer>
        </footer>
    </body>
</html>