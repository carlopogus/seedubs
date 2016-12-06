<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class JiraServiceProvider extends ServiceProvider
{

  public $requestUrl;

  public $jira_host;
  public $jira_api_version;
  public $jira_username;
  public $jira_password;

  public function __construct() {

  }

  /**
   * Construct the connectwise api request url.
   *
   * @return this.
   */
  private function constructRequestUrl() {
    $this->requestUrl = 'https://' . $this->jira_host . '/rest/api/' . $this->jira_api_version . '/';
    return $this;
  }
  /**
   * Make the call to the connectwise api.
   *
   * @return object
   */
  public function makeCall($action = 'GET', $endpoint, $data = []) {
    $url = $this->constructRequestUrl()->requestUrl;
    $headers = $this->buildHeaders($action, $data);
    $client = new \GuzzleHttp\Client(['base_uri' => $url]);
    $res = $client->request($action, $endpoint, $headers);
    return json_decode($res->getBody());
  }

  /**
   * Make a get request to the connectwise api.
   *
   * @return object
   */
  public function get($endpoint, $conditions = []) {
    return $this->makeCall('GET', $endpoint, $conditions);
  }

  /**
   * Build the query to send with the request.
   *
   * @return object
   */
  private function buildHeadersAuth(&$headers) {
    $headers['auth'] = [$this->jira_username, $this->jira_password];
  }

    /**
   * Build the query to send with the request.
   *
   * @return object
   */
  private function buildHeadersData(&$headers, $action, $data) {
    switch ($action) {
      case 'GET':
        $conditions = implode(' and ', $data);
        $headers['query'] = ['jql' => $conditions];
      break;
    }
  }

  /**
   * Build request headers.
   *
   * @return array
   */
  private function buildHeaders($action, $data) {
    $headers = array();
    $this->buildHeadersAuth($headers);
    if (!empty($data)) {
      $this->buildHeadersData($headers, $action, $data);
    }
    return $headers;
  }

   /**
     * Get Jira board statuses.
     */
    public function getStatuses() {
      $expires = Carbon::now()->addWeek();
      $statuses = Cache::remember('jira_statuses', $expires, function () {
          return $this->get('status');
      });
      return $statuses;
    }

        /**
     * Display json object of jira projects
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getProjects() {
      $expires = Carbon::now()->addWeek();
      $projects = Cache::remember('jira_projects', $expires, function () {
          return $this->get('project');
      });
      return $projects;
    }

    /**
     * Display json object of jira projects
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getProjectById($id) {
      $expires = Carbon::now()->addWeek();
      $projects = Cache::remember('jira_project_' . $id, $expires, function () use ($id) {
          return $this->get('project/' . $id);
      });
      return $projects;
    }

    /**
     * Display json object of jira projects
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getProjectsFiltered($phrase) {
      $projects = $this->getProjects();
      $filtered = array_filter($projects, function($var) use ($phrase){
        return strpos(strtolower($var->name), strtolower($phrase)) !== FALSE;
      });
      return $filtered;
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
  }
