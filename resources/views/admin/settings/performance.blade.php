@extends('layouts.app')

@section('content')
<div class="container">

  <h1>Performance</h1>
  <hr>

  <div class="panel panel-default">
    <div class="panel-body">

    {!! Form::open(['action' => 'SettingsController@clearCache']) !!}
      {!! Form::submit('Clear Caches', ['class' => 'btn btn-primary pull-left']) !!}
    {!! Form::close() !!}
    </div>
  </div>

</div>
@endsection
