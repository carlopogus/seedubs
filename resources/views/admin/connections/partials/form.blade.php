<div class="form-group">
    {!! Form::label('jira_project_key', 'Jira Project Key:') !!}
    {!! Form::text('jira_project_key', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('cw_company_id', 'CW Company Id:') !!}
    {!! Form::select('cw_company_id', $company, null, ['class' => 'form-control select-ajax--cw-company']) !!}
</div>

<div class="form-group">
    {!! Form::label('cw_agreement', 'CW Agreement:') !!}
    {!! Form::select('cw_agreement', $agreement, null, ['class' => 'form-control select-ajax--cw-agreement']) !!}
</div>

<div class="form-group">
    {!! Form::label('cw_service_board', 'Service Board:') !!}
    {!! Form::text('cw_service_board', 'Help Desk', ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('cw_ticket_priority', 'Ticket Priority:') !!}
    {!! Form::text('cw_ticket_priority', 'Priority 5 - No SLA', ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary form-control']) !!}
</div>
