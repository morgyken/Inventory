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
    ?>
    <head>
        <title>Sales Summary Report</title>
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
            <div id="logo">
            </div>
            <h1>Sales Summary:{{filter_description($data['filter'])}}</h1><br>
            <div id="company" class="clearfix">
                <div>{{config('practice.name')}}</div>
                <div>{{config('practice.building')}},<br /> {{config('practice.street')}}, {{config('practice.town')}}</div>
                <div>Telephone:{{config('practice.telephone')}}</div>
                <div>Email:<a href="mailto:{{config('practice.email')}}">{{config('practice.email')}}</a></div>
            </div>
        </header>
        <main>
            <br><br><br><br>

            <table style="width:100%" id="cashier" class="table table-borderless">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Receipt No.</th>
                        <th>Cashier</th>
                        <th>Amount</th>
                        <th>Mode</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $n = 0;
                    $cash_amnt = $cheq_amnt = $mpesa_amnt = $card_amnt = $insurance = 0;
                    ?>
                    @foreach($records as $record)
                    <tr>
                        <td>{{$n+=1}}</td>
                        <td>{{$record->receipt}}</td>
                        <td>{{$record->users->profile->full_name}}</td>


                        @if($record->payment_mode=='cash')
                        <td>{{$record->amountpaid->CashAmount}}</td>
                        <?php $cash_amnt +=$record->amountpaid->CashAmount ?>

                        @elseif($record->payment_mode=='mpesa')
                        <td>{{$record->amountpaid->MpesaAmount}}</td>
                        <?php $mpesa_amnt +=$record->amountpaid->MpesaAmount ?>

                        @elseif($record->payment_mode=='cheque')
                        <td>{{$record->amountpaid->ChequeAmount}}</td>
                        <?php $cheq_amnt +=$record->amountpaid->ChequeAmount ?>

                        @elseif($record->payment_mode=='card')
                        <td>{{$record->amountpaid->CardAmount}}</td>
                        <?php $card_amnt +=$record->amountpaid->CardAmount ?>

                        @elseif($record->payment_mode=='insurance')
                        <td>{{$record->amountpaid->InsuranceAmount}}</td>
                        <?php $insurance +=$record->amountpaid->InsuranceAmount ?>
                        @endif

                        <td>{{$record->payment_mode}}</td>
                        <td>{{(new Date($record->created_at))->format('jS M Y')}}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr><td><h4>Sales Summary</h4></td><td colspan="6"></td></tr>
                    <tr><td>Cash:</td><td colspan="5">{{number_format($cash_amnt,2)}}</td></tr>
                    <tr><td>MPESA:</td><td colspan="5">{{number_format($mpesa_amnt,2)}}</td></tr>
                    <tr><td>Cheque:</td><td colspan="5">{{number_format($cheq_amnt,2)}}</td></tr>
                    <tr><td>Card:</td><td colspan="5">{{number_format($card_amnt,2)}}</td></tr>
                    <tr><td>Total Sales:</td><td colspan="5">{{number_format($card_amnt+$cheq_amnt+$mpesa_amnt+$cash_amnt,2)}}</td></tr>
                </tfoot>
            </table>
        </main>
        <footer>
            <!-- This note was created on a computer and is valid without the signature and seal. -->
        </footer>
    </body>
</html>