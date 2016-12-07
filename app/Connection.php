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
        'status_maps',
        'jira_project_key',
        'cw_company_id',
        'cw_agreement',
        'cw_service_board',
        'cw_ticket_priority',
    ];

    protected $casts = [
        'status_maps' => 'array',
    ];

    public function getStatusMapsAttribute($value) {
        $obj = json_decode($value);
        if (empty($obj) || (empty($obj->cw) || empty($obj->jira))) {
            // $default = new \stdClass();
            // $default->cw = '';
            // $default->jira = '';
            $default = array('cw' => '', 'jira' => '');
            // $value = json_encode(array($default));
            $value = array($default);
        }
        // dd(json_decode($value));
        return $value;
    }

    private $connectwise;

}
