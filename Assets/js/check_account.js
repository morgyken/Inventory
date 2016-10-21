$(document).ready(function () {
    $("#acc").change(function () {
        $(this).find("option:selected").each(function () {
            if ($(this).attr("value") === "account") {
                $("#account").show();
            } else {
                $("#account").hide();
            }
        });
    }).change();

    $('#amount').keyup(function () {
        checkBogusWidthawal();
    });

    $('#accnt').click(function () {
        checkBogusWidthawal();
    });
    $('#acc').change(function () {
        checkBogusWidthawal();
    });

    function checkBogusWidthawal() {
        var amount = $('#amount').val();
        var type = $('#acc').val();
        var account_id = $('#accnt').val();
        //check bogus widthraw
        $.ajax({
            type: 'get',
            url: ACCOUNT_URL,
            data: {amount: amount, account_type: type, account_id: account_id},
            success: function (response) {
                $('#response').html(response);
            }
        });//ajax
    }


});