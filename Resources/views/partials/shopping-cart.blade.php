<?php
/*
 * =============================================================================
 *
 * Collabmed Solutions Ltd
 * Project: iClinic
 * Author: Samuel Okoth <sodhiambo@collabmed.com>
 *
 * =============================================================================
 */
?>
<div class="row">
    <div class="col-md-12">
        <table class="table table-condensed table-borderless table-responsive" id="products">
            <tbody>
            @foreach($data['products'] as $product)
                <tr id="row{{$product->id}}">
                    <td>
                        <input type="checkbox" name="product[]" value="{{$product->id}}" class="check"/>
                    </td>
                    <td>
                        <span id="name{{$product->id}}"> {{$product->name}}</span><br/>
                    </td>
                    <td>

                    </td>
                </tr>
            @endforeach
            </tbody>
            <thead>
            <tr>
                <th></th>
                <th>Item name</th>
                <th>Price</th>
                <th>Qty</th>
                <th></th>
            </tr>
            </thead>
        </table>
    </div>
</div>
