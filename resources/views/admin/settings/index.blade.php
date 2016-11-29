@extends('layouts.app')

@section('content')
<div class="container">

<h1>API Settings</h1>
<hr>
<!-- {!! Form::open(['action' => 'SettingsController@update']) !!} -->
{!! Form::model(['action' => 'SettingsController@update']) !!}

<div class="panel panel-default">
  <div class="panel-body">
    @if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
<table class="table table-striped">
    <tr>
        <th>Name</th>
        <th>Value</th>
    </tr>
    @foreach($settings as $setting)
    <tr class="form-group">
        <td>{!! Form::label($setting->key, $setting->name) !!}</td>
        <td>{!! Form::text($setting->key, $setting->value, ['class' => 'form-control']) !!}</td>
    </tr>
    @endforeach
</table>
{!! Form::submit('Save Settings', ['class' => 'btn btn-primary pull-left']) !!}
{!! Form::close() !!}
</div></div>

</div>
@endsection
