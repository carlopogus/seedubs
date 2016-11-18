@extends('layouts.app')

@section('content')
<div class="container">

<h1>Connections</h1>
<hr>

<table class="table">
    <tr>
        <th>#</th>
        <th>Jira Project Key</th>
        <th>CW Company Id</th>
        <th>CW Agreement</th>
        <th>CW Service Board</th>
        <th>CW Ticket Priority</th>
    </tr>
    @foreach($connections as $connection)
    <tr class="form-group">
        <td>{{ $connection->id }}</td>
        <td>{{ $connection->jira_project_key }}</td>
        <td>{{ $connection->cw_company_id }}</td>
        <td>{{ $connection->cw_agreement }}</td>
        <td>{{ $connection->cw_service_board }}</td>
        <td>{{ $connection->cw_ticket_priority }}</td>
    </tr>
    @endforeach
</table>

</div>
@endsection
