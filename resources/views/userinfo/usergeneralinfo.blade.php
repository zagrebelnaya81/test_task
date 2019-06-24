
<table class="table">
    <tbody>
        <tr>
            <td>Icons</td><td></td>
        </tr>
        <tr>
            <td>Date</td><td>{{$user->date}}</td>
        </tr>
        <tr>
            <td>Name</td><td>{{$user->name}}</td>
        </tr>
        <tr>
            <td>Phone</td><td>{{$user->phone}}</td>
        </tr>
        <tr>
            <td>Email</td><td>{{$user->email}}</td>
        </tr>
        {{--{{print_r($dats[0])}}--}}
        @foreach ($dats as $lab)
            <tr>
                @foreach ($lab as $l)
                <td>{{$l->label}}</td>
                <td>{{$l->value}}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>

