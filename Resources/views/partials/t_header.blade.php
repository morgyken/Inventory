<table>
    <tbody>
        <tr>
        <td>
            <p style="font-size: 90%;">
           <!--  {{config('practice.building')?config('practice.building').',':''}}
            {{config('practice.street')?config('practice.street').',':''}}
            {{config('practice.town')}}<br>
            {{config('practice.telephone')?'Call Us:- '.config('practice.telephone'):''}} -->
            <div>{{config('practice.name')}}</div>
                <div>{{config('practice.building')}},<br /> {{config('practice.street')}}, {{config('practice.town')}}</div>
                <div>Telephone:{{config('practice.telephone')}}</div>
                <div>P.O BOX: {{config('practice.address')}}<br></div>
                <div>Email:<a href="mailto:{{config('practice.email')}}">{{config('practice.email')}}</a></div>

                    </p>

        </td>    


      <!--   <td>
            <img  src="{{realpath(base_path('/public/reciept.jpg'))}}" alt="Company Logo">
        

        </td> -->    
        </tr>
    </tbody>
</table>