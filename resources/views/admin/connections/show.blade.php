@extends('layouts.app')

@section('content')
<div class="container">

    <h1>{{$connection->jira_project_key}} Connection</h1>
    <hr>

    <div class="panel panel-default">
        <div class="panel-body">
            {!! Form::open([ 'action' => [ 'ConnectionsController@destroy', $connection ], 'method' => 'delete', 'class' => 'pull-right' ]) !!}
            <a href="{{ action('ConnectionsController@edit', [$connection->id]) }}" class="btn btn-primary btn-xs" >Edit</a>
            {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-xs']) !!}
            {!! Form::close() !!}
        </div>
        <div class="panel-body">
            <table class="table table-striped">
                <tr>
                    <td><label>ID</label></td>
                    <td>{{ $connection->id }}</td>
                </tr>
                <tr>
                    <td><label>Jira Project Key</label></td>
                    <td>{{ $connection->jira_project_key }}</td>
                </tr>
                <tr>
                    <td><label>CW Company Id</label></td>
                    <td>{{ $connection->cw_company_id }}</td>
                </tr>
                <tr>
                    <td><label>CW Agreement</label></td>
                    <td>{{ $connection->cw_agreement }}</td>
                </tr>
                <tr>
                    <td><label>CW Service Board</label></td>
                    <td>{{ $connection->cw_service_board }}</td>
                </tr>
                <tr>
                    <td><label>CW Ticket Priority</label></td>
                    <td>{{ $connection->cw_ticket_priority }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection
