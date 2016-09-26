
<?php
/*
 * =============================================================================
 *
 * Collabmed Solutions Ltd
 * Project: iClinic
 * Author: Bravo Kiptoo <bkiptoo@collabmed.com>
 *
 * =============================================================================
 */
?>

@extends('layouts.app')
@section('content_title','Receive Invoice')
@section('content_description','Select Creditor and complete the form to proceed')

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Receive Invoice</h3>
    </div>

    <style>
        label{
            text-align: right;
        }
    </style>
    <div class="box-body">
        <div class="row">
            <div class="col-md-8">

                <form method="post" action="{{route('inventory.suppliers.invoice')}}">
                    <input type="hidden" class="form-horizontal" name="_token" id="csrf-token" value="{{ Session::token() }}" />

                    <div class="form-group row">
                        <label class="col-xs-4 col-form-label" >Creditor(Supplier)</label>
                        <div class="col-xs-8">
                            <select name = "creditor" class="form-control input-medium" required title = "Select Creditor">
                                <option></option>
                                @foreach($data['suppliers'] as $s)
                                <option value="{{$s->id}}">{{$s->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-xs-4 col-form-label">Date of Invoice</label>
                        <div class="col-xs-8">
                            <input type="text" name="date" value="" id="date1" class="form-control"  data-date-format="dd-M-yyyy" required readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-xs-4 col-form-label">GL Account</label>
                        <div class="col-xs-8">
                            <select name ="gl_account" class="form-control" required title = "Select GL Account">
                                <option></option>
                                @foreach($data['gl_accounts'] as $gl)
                                <option value="{{$gl->id}}">{{$gl->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-xs-4 col-form-label">Amount</label>
                        <div class="col-xs-8">
                            <input type="text" id="amount" value="" class="form-control" name = "amount" title = "Enter Amount">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-xs-4 col-form-label">Invoice Number</label>
                        <div class="col-xs-8">
                            <input type="text" class="form-control" name = "number" title = "Invoice Number" placeholder = "Enter Invoice Number" >
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-xs-4 col-form-label">Due Date</label>
                        <div class="col-xs-8">
                            <input type="text" name="due_date" value="" id="date2" class="form-control date-picker"  data-date-format="dd-M-yyyy" required readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-xs-4 col-form-label">Payment Status</label>
                        <div class="col-xs-8">
                            <select name = "status" class="form-control" required placeholder = "Enter Payment Status" title = "Enter Payment Status ">
                                <option value="paid">Paid</option>
                                <option value="unpaid">Unpaid</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-xs-4 col-form-label">Description</label>
                        <div class="col-xs-8">
                            <textarea name = "description" class="form-control" placeholder = "Enter Description">
                            </textarea>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-xs-4 col-form-label"></label>
                        <div class="col-xs-8">
                            <button class="form-control btn-primary">Proceed</button>
                        </div>
                    </div>



                </form>

            </div>
        </div>
    </div>



    <div class="box-header with-border">
        <h3 class="box-title">Received Invoices</h3>
    </div>

    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                @if(!$data['inv']->isEmpty())
                <table class="table table-responsive table-striped" id="dtable">
                    <tbody>
                        <?php $count = 0; ?>
                        @foreach($data['inv'] as $inv)
                        <?php $count +=1; ?>
                        <tr>
                            <td></td>
                            <td>{{$inv->number}}</td>
                            <td>{{$inv->creditors->name}}</td>
                            <td>{{$inv->amount}}</td>
                            <td>
                                @if($inv->status=='unpaid')
                                <span class="label label-danger">
                                    <i class="fa fa-cog fa-spin" aria-hidden="true"></i>
                                    {{$inv->status}}
                                </span>
                                @else
                                <span class="label label-success">
                                    <i class="fa fa-check" aria-hidden="true"></i>
                                    {{$inv->status}}
                                </span>
                                @endif
                            </td>
                            <td><a href="{{route('inventory.suppliers.invoice.details', $inv->id)}}">
                                    <span class="label label-primary">
                                        <i class="fa fa-eye" aria-hidden="true"></i>details</span>
                                </a></td>
                        </tr>
                        @endforeach
                    </tbody>
                    <thead>
                        <tr>
                            <th></th>
                            <th>Invoice</th>
                            <th>Creditor</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
                @else
                <div class="alert alert-info">
                    <p>No Invoices</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#date1").datepicker({dateFormat: 'yy-mm-dd', onSelect: function (date) {
                $("#date2").datepicker('option', 'minDate', date);
            }});
        $("#date2").datepicker({dateFormat: 'yy-mm-dd'});
        $('#dtable').dataTable();
    });
</script>
@endsection
