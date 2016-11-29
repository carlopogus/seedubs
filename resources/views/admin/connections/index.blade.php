@extends('layouts.app')

@section('content')
<div class="container">

  <h1>Manage Connections</h1>
  <hr>
  <div class="panel panel-default">
    <div class="panel-body">

      <table class="table table-striped">
        <tr>
          <th>#</th>
          <th>Jira Project Key</th>
          <th>CW Service Board</th>
          <th>CW Ticket Priority</th>
          <th>Actions</th>
        </tr>
        @foreach($connections as $connection)
        <tr class="form-group">
          <td>{{ $connection->id }}</td>
          <td>{{ $connection->jira_project_key }}</td>
          <td>{{ $connection->cw_service_board }}</td>
          <td>{{ $connection->cw_ticket_priority }}</td>
          <td>
            <a href="{{ action('ConnectionsController@show', [$connection->id]) }}" class="btn btn-success btn-xs">View</a>
            <a href="{{ action('ConnectionsController@edit', [$connection->id]) }}" class="btn btn-primary btn-xs" >Edit</a>
          </td>
        </tr>
        @endforeach
      </table>
    </div>
  </div>
</div>
@endsection
