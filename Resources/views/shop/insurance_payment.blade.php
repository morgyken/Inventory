
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
    <div class="col-md-12" id="ins">
        {!! Form::open(['class'=>'form-horizontal']) !!}
        <div class="col-md-4 col-lg-6">
            <div class="form-group {{ $errors->has('patient') ? ' has-error' : '' }}">
                {!! Form::label('patient', 'Patient',['class'=>'control-label col-md-4']) !!}
                <div class="col-md-8">
                    <select name="patient" id="patient_select" class="form-control" style="width:100%;" required=""></select>
                    {!! $errors->first('patient', '<span class="help-block">:message</span>') !!}
                </div>
            </div>
        </div>

        <div class="col-md-4 col-lg-6" id="scheme_area">
            <div class="form-group {{ $errors->has('scheme') ? ' has-error' : '' }}" id="schemes">
                {!! Form::label('scheme', 'Insurance Scheme',['class'=>'control-label col-md-4']) !!}
                <div class="col-md-8" id="options">
                    <select name="scheme" id="patient_scheme" class="form-control" style="width:100%;" required="">

                    </select>
                    {!! $errors->first('scheme', '<span class="help-block">:message</span>') !!}
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('#scheme_area').hide();
        $("#ins").hover(function () {
            var patient = $('#patient_select').val();
            $.ajax({
                url: "{{route('api.inventory.clients')}}",
                data: {'patient': patient},
                success: function (data) {
                    $('#scheme_area').show();
                    $("#patient_scheme").html(data);
                }});
        });

    });
    var PATIENTS_URL = "{{route('api.reception.suggest_patients')}}";
</script>
<script src="{{m_asset('reception:js/appointments.min.js')}}"></script>