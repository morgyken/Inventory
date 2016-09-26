/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function () {
    /* function calculate_total() {
     var SUM = 0;
     $('#tab_logic tbody tr').each(function (i, row) {
     var row = $(row);
     var qty = row.find('input[name=qty' + i + ']').val();
     var price = row.find('input[name=price' + i + ']').val();
     var total = qty * price;
     if (total) {
     SUM = SUM + total;
     $("#total" + i).html(total.toFixed(2));
     }
     });
     $('#total').html(SUM.toFixed(2));
     }*/
    function calculate_total() {
        var SUM = 0;
        var DISCOUNT = 0;
        $('#tab_logic tbody tr').each(function (i, row) {
            var row = $(row);
            var qty = row.find('input[name=qty' + i + ']').val();
            var price = row.find('input[name=price' + i + ']').val();
            var dis = row.find('input[name=dis' + i + ']').val();
            var p_size = row.find('input[name=package' + i + ']').val();
            var total = qty * price;
            var discounts = (dis * price) / 100;
            if (!total) {
                total = 0;
            }
            if (!discounts) {
                discounts = 0;
            }
            SUM += total;
            var the_discount = (discounts * qty);
            var at_price = total - the_discount;
            $("#total" + i).html(at_price.toFixed(2));
            DISCOUNT += the_discount;
        });
        $('#total').html(SUM.toFixed(2));
        $('#discount').html(DISCOUNT.toFixed(2));
        $('#net').html((SUM - DISCOUNT).toFixed(2));
        $('#sum').html(SUM.toFixed(2));
    }
    $('#tab_logic input').keyup(function () {
        calculate_total();
    });
    calculate_total();
});