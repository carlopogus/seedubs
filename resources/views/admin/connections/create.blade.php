@extends('layouts.app')

@section('styles')
    <link href="/libs/select2/select2.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="container">

<h1>Create A New Connection</h1>
<hr>

<div class="panel panel-default">
  <div class="panel-body">

{!! Form::open(['url' => 'connections']) !!}

    @include('admin.connections.partials.form', ['submitButtonText' => 'Create Connection'])

{!! Form::close() !!}

</div></div>

</div>
@endsection

@section('scripts')
    <script src="/libs/select2/select2.min.js"></script>
    <script src="/js/connections.form.js"></script>
@endsection
