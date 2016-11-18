{!! Form::hidden('user_id', 1) !!}
<div class="form-group">
    {!! Form::label('jira_project_key', 'Jira Project Key:') !!}
    {!! Form::text('jira_project_key', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('cw_company_id', 'CW Company Id:') !!}
    {!! Form::text('cw_company_id', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('cw_agreement', 'CW Agreement:') !!}
    {!! Form::text('cw_agreement', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('cw_service_board', 'Service Board:') !!}
    {!! Form::text('cw_service_board', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('cw_ticket_priority', 'Ticket Priority:') !!}
    {!! Form::text('cw_ticket_priority', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary form-control']) !!}
</div>
