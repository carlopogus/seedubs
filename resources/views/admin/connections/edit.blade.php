@extends('layouts.app')

@section('styles')
    <link href="/css/select2.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="container">

<h1>Edit Connection</h1>
<hr>

{!! Form::model($connection, ['method' => 'PUT', 'action' => ['ConnectionsController@update', $connection->id]]) !!}

    @include('admin.connections.partials.form', ['submitButtonText' => 'Update Connection'])

{!! Form::close() !!}

{!! Form::open([ 'action' => [ 'ConnectionsController@destroy', $connection ], 'method' => 'delete', 'class' => 'pull-right' ]) !!}
{!! Form::submit('Delete', ['class' => 'btn btn-danger btn-xs']) !!}
{!! Form::close() !!}

</div>
@endsection

@section('scripts')
    <script src="/js/select2.min.js"></script>
    <script src="/js/connections.form.js"></script>
@endsection
