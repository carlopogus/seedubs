@extends('layouts.app')

@section('content')
<div class="container">

<h1>Create A New Connection</h1>
<hr>

{!! Form::open(['url' => 'connections']) !!}

    @include('admin.connections.partials.form', ['submitButtonText' => 'Create Connection'])

{!! Form::close() !!}

</div>
@endsection
