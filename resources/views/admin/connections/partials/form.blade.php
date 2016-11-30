@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="form-group">
    {!! Form::label('jira_project_key', 'Jira Project Key:') !!}
    {!! Form::select('jira_project_key', $project, null, ['class' => 'form-control select-ajax--jira-project']) !!}
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
    {!! Form::select('cw_service_board', $boards, $connection->cw_company_id, ['class' => 'form-control select-ajax--cw-boards']) !!}
</div>

<div class="form-group">
    {!! Form::label('cw_ticket_priority', 'Ticket Priority:') !!}
    {!! Form::select('cw_ticket_priority', $priorities, $connection->cw_ticket_priority, ['class' => 'form-control select-ajax--cw-priority']) !!}
</div>

<div class="form-group">
    {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary pull-left']) !!}
</div>
