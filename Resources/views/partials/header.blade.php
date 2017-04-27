<h1 style="text-align: center;">{{config('practice.name')}}</h1><br>
<table>
    <tbody>
        <tr>
        <td class="col-md-4">
            <p style="font-size: 90%;">
           <div>{{config('practice.name')}}</div>
                <div>{{config('practice.building')}},<br /> {{config('practice.street')}}, {{config('practice.town')}}</div>
                <div>Telephone:{{config('practice.telephone')}}</div>
                <div>P.O BOX: {{config('practice.address')}}<br></div>
                <div>Email:<a href="mailto:{{config('practice.email')}}">{{config('practice.email')}}</a></div>
        </p>

        </td>    


        <td class="col-md-4">
           <img style="width:200; height:auto; float: right;" src="{{realpath(base_path('/public/reciept.jpg'))}}"/>
        </td>    
        </tr>
    </tbody>
</table>
<br>
