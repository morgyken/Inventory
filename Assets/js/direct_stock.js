$('table').hide();
$(document).ready(function () {
    $('body').on('focus', ".datepicker", function () {
        $(this).datepicker({
            dateFormat: 'yy-mm-dd',
            minDate: 0
        });
    });

    $(document).on('change', '.xt', function (e) {
        e.stopImmediatePropagation();
        var name = $(this).attr('c');
        var package_size = parseInt($('[name=package' + name + ']').val());
        var qty = parseInt($('[name=qty' + name + ']').val());
        $all = $(this).val() / (package_size * qty);
        console.log(name, package_size, qty, $all);
        $('[name=price' + name + ']').val($all.toFixed(2));
        calculate_total();
    });

    function calculate_total() {
        var SUM = 0;
        var items = [];
        $('#tab_logic').find('tbody tr').each(function (i, row_get) {
            var row = $(row_get);
            var qty = parseInt(row.find('input[name=qty' + i + ']').val());
            var price = parseFloat(row.find('input[name=price' + i + ']').val());
            var amount = parseFloat(row.find('input[name=total' + i + ']').val());
            var dis = parseFloat(row.find('input[name=dis' + i + ']').val());
            var tax = parseFloat(row.find('input[name=tax' + i + ']').val());
            var package_size = parseInt(row.find('input[name=package' + i + ']').val());
            var total = 0;
            var discount_rate = 0;
            if (qty && price) {
                if (package_size) {
                    //   qty = package_size * qty;
                }
                total = qty * price;
                if (amount) {
                    total = amount;
                }
                if (!total) {
                    total = 0;
                }
                var discount_rate = (dis / 100).toFixed(2);
                var t = (tax / 100);
                var taxable = parseFloat((t * price).toFixed(2));
                if (!discount_rate) {
                    discount_rate = 0;
                }
                var at_price = parseFloat(total + taxable - (discount_rate * total));
                if (!amount)
                    $("#total" + i).val(at_price);
                items.push({qty: qty, price: price, total: total, rate: discount_rate, net: at_price});
                SUM += at_price;
            }
        });
        $('#total').html(SUM);
        $('#amount').val(SUM);
    }

    $('#tab_logic').find('input:not(.xt)').change(function () {
        calculate_total();
    });
    var i = 1;
    $("#add_row").click(function () {
        var to_add = "<td><select name='item" + i + "' class='select2-single' style='width: 100%'></select></td><td><input type='text' name='package" + i + "' value='1' placeholder='Packaging' size='2'/></td><td><input type='text' name='qty" + i + "' size='2' value='1'/></td><td><input type='text' name='bonus" + i + "' value='0' size='2'/></td><td><input class='datepicker' type='text' id='expiry" + i + "' name='expiry" + i + "' placeholder='Expiry Date'/></td><td><input type='text' name='price" + i + "' size='4'/></td><td><input type='text' name='dis" + i + "' value='0' size='2'/></td><td><input type='text' name='tax" + i + "' placeholder='eg VAT' value='0' size='3'/></td><td><input type='text' value='0' c='" + i + "'  class='xt' name='total" + i + "' id='total" + i + "'/></td>";
        $('#addr' + i).html(to_add);
        $('#tab_logic').append('<tr id="addr' + (i + 1) + '"></tr>');
        map_select2(i);
        i++;
    });
    $('#tab_logic').on('click', ".remove", function (e) {
        e.preventDefault();
        $(this).closest('tr').remove();
        calculate_total();
    });

    function map_select2(i) {
        $('#addr' + i + ' select').select2({
            "theme": "classic",
            "placeholder": 'Please select an item',
            "formatNoMatches": function () {
                return "No matches found";
            },
            "formatInputTooShort": function (input, min) {
                return "Please enter " + (min - input.length) + " more characters";
            },
            "formatInputTooLong": function (input, max) {
                return "Please enter " + (input.length - max) + " less characters";
            },
            "formatSelectionTooBig": function (limit) {
                return "You can only select " + limit + " items";
            },
            "formatLoadMore": function (pageNumber) {
                return "Loading more results...";
            },
            "formatSearching": function () {
                return "Searching...";
            },
            "minimumInputLength": 2,
            "allowClear": true,
            "ajax": {
                "url": PRODUCTS_URL,
                "dataType": "json",
                "cache": true,
                "data": function (term, page) {
                    return {
                        term: term
                    };
                },
                "results": function (data, page) {
                    return {results: data};
                }
            }
        });
        $('#addr' + i + ' select').on('select2:select', function (evt) {
            var selected = $(this).find('option:selected');
            var rate = selected.data().data.tax;
        });
    }

    map_select2(0);
    $('table').show();
});