@extends('layouts.master')

{{-- Content --}}
@section('content')
    <div class="page-header">
        <div class="pull-right flip">
            <a class="btn btn-primary btn-xs close_popup" href="{{ URL::previous() }}">
                <span class="glyphicon glyphicon-backward"></span> {!! trans('admin/admin.back') !!}
            </a>
        </div>
    </div>
    <div class="container" id="content">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">icon</th>
                <th scope="col">date</th>
                <th scope="col">name</th>
                <th scope="col">phone</th>
                <th scope="col">email</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($user as $users)
            <tr id="{{$users->id}}">
                <th scope="row"></th>
                <td>{{$users->date}}</td>
                <td>{{$users->name}}</td>
                <td>{{$users->phone}}</td>
                <td>{{$users->email}}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@stop
<script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<script type="text/javascript">
    $(function() {
        $("#{{$users->id}}").click(function (e) {

        var id = '{{$users->customer_id}}';
            $.ajax({
                type:'POST',
                url:'ajaxRequest',
                data:{id:id, _token:'{{csrf_token()}}'},
                success:function(data){
                    $('#content').html(data);
                }
            });

        });
    });
</script>
