<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Connection extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'jira_project_key',
        'cw_company_id',
        'cw_agreement',
        'cw_service_board',
        'cw_ticket_priority',
    ];

    private $connectwise;

}
