@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('jira_project_key', 'Jira Project Key:') !!}
            {!! Form::select('jira_project_key', $jira_project_key, $connection->jira_project_key, ['class' => 'form-control select-ajax--jira-project']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('cw_company_id', 'CW Company Id:') !!}
            {!! Form::select('cw_company_id', $cw_company_id, $connection->cw_company_id, ['class' => 'form-control select-ajax--cw-company']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('cw_agreement', 'CW Agreement:') !!}

            {!! Form::select('cw_agreement', $cw_agreement, $connection->cw_agreement, [(!empty($connection->cw_agreement)?'active':'disabled'), 'class' => 'form-control select-ajax--cw-agreement']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('cw_service_board', 'Service Board:') !!}
            {!! Form::select('cw_service_board', $cw_service_board, $connection->cw_service_board, ['class' => 'form-control select-ajax--cw-boards']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('cw_ticket_priority', 'Ticket Priority:') !!}
            {!! Form::select('cw_ticket_priority', $cw_ticket_priority, $connection->cw_ticket_priority, ['class' => 'form-control select-ajax--cw-priority']) !!}
        </div>
    </div>

    <div class="col-md-6">
        <div class="status-maps">
            <label>Jira to Connectwise ticket status mapping</label>


            @if ($connection->status_maps)
                @foreach ($connection->status_maps as $index => $map)
                <div class="status-map-group">
                    <div class="status-map-group--item form-group">
                        <div class="form-inline">
                            <div class="input-group">
                                {!! Form::select("status_maps[$index][jira]", $jira_status_maps, $map['jira'], ['class' => 'form-control jira-cw-status-map jira-cw-status-map--jira select-ajax--status-map-jira']) !!}
                            </div>
                            <span class="glyphicon glyphicon-resize-horizontal" aria-hidden="true"></span>
                            <div class="input-group">
                                {!! Form::select("status_maps[$index][cw]", ['' => 'Select a Connectwise status'], $map['cw'], ['class' => 'form-control jira-cw-status-map jira-cw-status-map--cw select-ajax--status-map-cw']) !!}
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                <div class="form-group">
                    <button type="button" class="btn btn-primary btn-sm jira-cw-status-map-add">Add another mapping</button>
                </div>
            @else
            <div class="status-map-group">
                    <div class="status-map-group--item form-group">
                        <div class="form-inline">
                            <div class="input-group">
                                {!! Form::select('status_maps[0][jira]', $jira_status_maps, null, ['disabled', 'class' => 'form-control jira-cw-status-map jira-cw-status-map--jira select-ajax--status-map-jira']) !!}
                            </div>
                            <span class="glyphicon glyphicon-resize-horizontal" aria-hidden="true"></span>
                            <div class="input-group">
                                {!! Form::select('status_maps[0][cw]', ['' => 'Select a Connectwise status'], null, ['disabled', 'class' => 'form-control jira-cw-status-map jira-cw-status-map--cw select-ajax--status-map-cw']) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <button disabled type="button" class="btn btn-primary btn-sm jira-cw-status-map-add">Add another mapping</button>
                </div>
            @endif
        </div>
    </div>
</div>



<div class="form-group">
    {!! Form::submit($submitButtonText, ['class' => 'btn btn-success pull-left']) !!}
</div>

