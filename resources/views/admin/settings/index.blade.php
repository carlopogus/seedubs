@extends('layouts.app')

@section('content')
<div class="container">

<h1>Admin Settings</h1>
<hr>
<!-- {!! Form::open(['action' => 'SettingsController@update']) !!} -->
{!! Form::model(['action' => 'SettingsController@update']) !!}

<div class="panel panel-default">
  <div class="panel-body">
<table class="table">
    <tr>
        <th>Name</th>
        <th>Value</th>
    </tr>
    @foreach($settings as $setting)
    <tr class="form-group">
        <td>{!! Form::label($setting->name, $setting->name) !!}</td>
        <td>{!! Form::text($setting->name, $setting->value, ['class' => 'form-control']) !!}</td>
    </tr>
    @endforeach
</table>
{!! Form::submit('Save', ['class' => 'btn btn-default']) !!}
{!! Form::close() !!}
</div></div>

</div>
@endsection
