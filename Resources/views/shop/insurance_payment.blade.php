
<div class="form-group">
    <div class="col-sm-6">
        <div class="form-group {{ $errors->has('payment_mode') ? ' has-error' : '' }} req">
            <div>
                <input type="hidden" value="insurance" name="payment_mode" >
            </div>
        </div>
    </div>
</div>
<div id="wrapper1">
    <div class="col-md-12">
        <fieldset>
            <legend> Find Client  </legend>

            <div class="form-group row">
                <label class="col-xs-4 col-form-label">Search Client</label>
                <div class="col-xs-8">
                    <input type="text" id="client" class="form-control" name="client" placeholder="Search Patient By Name">
                    <table class="table table-condensed" id="fbk">
                        <thead class="theader">
                            <tr>
                                <th>Firstname</th>
                                <th>Lastname</th>
                                <th>Phone</th>
                            </tr>
                        </thead>
                        <tbody id="clients"></tbody>
                    </table>

                </div>
            </div>
            <input type="hidden" class="clientID" name="customer_id">
            <div class="form-group row">
                <label class="col-xs-4 col-form-label">Insurance Company:</label>
                <div class="col-xs-8">
                    {!! Form::select('company',get_insurance_companies(), null, ['id' => 'company','class' => 'form-control company', 'placeholder' => 'Choose...']) !!}
                </div>
            </div>

            <div class="form-group row">
                <label class="col-xs-4 col-form-label">Insurance Scheme:</label>
                <div class="col-xs-8">
                    <select name="scheme" id="scheme" class="form-control scheme">
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-xs-4 col-form-label">Policy Number</label>
                <div class="col-xs-8">
                    <input type="text" name="policy"autocomplete="off"id="policy" class="form-control" >

                    <table class="table table-condensed" id="fbk2">
                        <thead class="theader2">
                            <tr>
                                <th>Policy Number</th>
                                <th>Scheme</th>
                                <th>Company</th>
                            </tr>
                        </thead>
                        <tbody id="plns"></tbody>
                    </table>

                </div>
            </div>
        </fieldset>
    </div>
</div>
<script type="text/javascript">

    $(document).ready(function () {
        $('.theader').hide();
        $('.theader2').hide();
        $("#client").keyup(function () {
            $('.theader').show();
            var client = this.value;
            $.ajax({
                url: "{{route('api.inventory.clients')}}",
                data: {'client': client},
                success: function (data) {
                    $("#clients").html(data);
                }});
        });

        $("#policy").keyup(function () {
            $('.theader2').show();
            var policy = this.value;
            var firm = $('.company').val();
            var scheme = $('.scheme').val();
            var client = $('.clientID').val();
            $.ajax({
                url: "{{route('api.inventory.client.pln')}}",
                data: {'policy': policy, 'firm': firm, 'scheme': scheme, 'client': client},
                success: function (data) {
                    $("#plns").html(data);
                }});
        });
    });

    function appendInfo(client_id, fn, ln) {
        $('.clientID').val(client_id);
        $('#client').val(fn + ' ' + ln);
        $('#fbk').hide();
    }

    function appendPLN(pln) {
        $('#policy').val(pln);
        $('#fbk2').hide();
    }

</script>