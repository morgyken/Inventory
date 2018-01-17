/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/* global PRODUCTS_URL */

$(document).ready(function () {

    $(".date").datepicker({minDate: "0"});

    var inventoryIndex = 0;

    $("#add-row").click(function addRow(){

        var content = getContent(inventoryIndex);

        $("#item-container").append(content);

        inventoryIndex++;

        mapSelect(inventoryIndex);

    });

    function getContent(currentIndex){

        var index = currentIndex + 1;

        var id = "item-" + index;

        var name = "items["+index+"][product_id]";

        var quantity = "items["+index+"][quantity]";

        return "<div id="+id+" class='col-md-12'>"+
            "<div class='form-group'>"+
            "<div class='col-md-6'>"+
            "<select class='col-md-12' name="+name+"></select>"+
            "</div>"+
            "<div class='col-md-4'>"+
            "<input class='form-control' name="+quantity+" />"+
            "</div>"+
            "<div class='col-md-2'>"+
            "<button value="+index+" type='button' class='btn btn-xs btn-danger remove'><i class='fa fa-trash-o'></i></button>"+
            "</div>"+
            "</div>"+
            "</div>";
    }

    $("body").on("click", ".remove", function (e) {
        $("#item-" + e.target.value).remove();
    });

    function mapSelect(index){
        $("#item-" + index + " select").select2({
            "theme": "classic",
            "placeholder": "Please select an item",
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
            "formatLoadMore": function () {
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
                "data": function (term) {
                    return {
                        term: term
                    };
                },
                "results": function (data) {
                    return {results: data};
                }
            }
        });
    }

    mapSelect(inventoryIndex);
});