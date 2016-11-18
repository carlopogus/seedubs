@extends('layouts.app')

@section('content')
<div class="container">

<h1>Edit Connection</h1>
<hr>

{!! Form::model($connection, ['method' => 'PUT', 'action' => ['ConnectionsController@update', $connection->id]]) !!}

    @include('admin.connections.partials.form', ['submitButtonText' => 'Update Connection'])

{!! Form::close() !!}

</div>
@endsection
