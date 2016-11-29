<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $primaryKey = 'key';
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key', 'value', 'name', 'description'
    ];

    // public function scopeKey($query, $name) {
    //   return $query->where('name', $name);
    // }

    // public function jiraQuery($endpoint) {
    //     $jira_host = $this::find('jira_host')->value;
    //     $jira_api = $this::find('jira_api')->value;
    //     $jira_username = $this::find('jira_username')->value;
    //     $jira_password = $this::find('jira_password')->value;
    //     $client = new \GuzzleHttp\Client();
    //     $res = $client->request('GET', $jira_host . '/' . $jira_api . '/' . $endpoint, [
    //         'auth' => [$jira_username, $jira_password]
    //     ]);
    //     return json_decode($res->getBody());
    // }

    // public function getJiraProjects() {
    //     $expiresAt = Carbon::now()->addHours(12);
    //     return Cache::remember('jiraProjects', $expiresAt, function() {
    //         return $this->jiraQuery('project');
    //     });
    // }

}
