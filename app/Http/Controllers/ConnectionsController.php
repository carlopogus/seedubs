<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Http\Requests\ConnectionRequest;
use Illuminate\Http\Request;
use App\Connection;
use Illuminate\Support\Facades\Cache;
use App\Setting;
use App\Providers\ConnectwiseProvider;
use App\Providers\JiraServiceProvider;


class ConnectionsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ConnectwiseProvider $connectwise, JiraServiceProvider $jira)
    {
      $settings = Setting::pluck('value', 'key');
      $connectwise->cw_host = $settings['cw_host'];
      $connectwise->cw_release = $settings['cw_release'];
      $connectwise->cw_api_version = $settings['cw_api_version'];
      $connectwise->cw_COID = $settings['cw_COID'];
      $connectwise->cw_api_key = $settings['cw_api_key'];
      $connectwise->cw_api_secret = $settings['cw_api_secret'];
      $this->connectwise = $connectwise;
      $jira->jira_host = $settings['jira_host'];
      $jira->jira_api_version = $settings['jira_api_version'];
      $jira->jira_username = $settings['jira_username'];
      $jira->jira_password = $settings['jira_password'];
      $jira->jira_cw_field = $settings['jira_cw_field'];
      $this->jira = $jira;
        // $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $connections = Connection::orderBy('jira_project_key', 'desc')->get();
      return view('admin.connections.index', compact('connections'));
    }

    public function test() {
      dd($this->jira->get('project'));
      return 'hello';
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Connection $connection)
    {
      $company = array();
      $agreement = array();
      $project = array();
      $boards = array();
      $priorities = array();

      foreach ($this->getCwServiceBoards() as $board) {
        $boards[$board->id] = $board->name;
      }

      foreach($this->getCwServicePriorities() as $priority) {
        $priorities[$priority->id] = $priority->name;
      }

      return view('admin.connections.create', compact('connection', 'company', 'agreement', 'project', 'boards', 'priorities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ConnectionRequest $request, Connection $connection)
    {
      // dd([$connection, $request->all()]);
      $connection = Connection::create($request->all());
      return redirect('connections')->with([
        'message' => "Connection \"{$request->all()['jira_project_key']}\" has been created",
        'alert-class' => "alert-success"
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Connection $connection)
    {

      $cw_company = $this->connectwise->get('company/companies', ['id = ' . $connection->cw_company_id]);
      if (!is_null($cw_company)) {
        $connection->cw_company_name = $cw_company[0]->name;
      }
      $cw_agreement =  $this->connectwise->get('finance/agreements', ['id = ' . $connection->cw_agreement]);
      if (!is_null($cw_agreement)) {
        $connection->cw_agreement_name = $cw_agreement[0]->name;
      }

      return view('admin.connections.show', compact('connection'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Connection $connection)
    {
      $project = array($connection->jira_project_key => $connection->jira_project_key);
      $company = $this->getConnectionCompanySelectDefault($connection);
      $agreement = $this->getConnectionAgreementSelectDefault($connection);
      $boards = [];
      $priorities = [];
      foreach ($this->getCwServiceBoards() as $board) {
        $boards[$board->id] = $board->name;
      }
      foreach($this->getCwServicePriorities() as $priority) {
        $priorities[$priority->id] = $priority->name;
      }
      return view('admin.connections.edit', compact('connection', 'company', 'agreement', 'project', 'boards', 'priorities'));
    }


    /**
     * return cw company for connection.
     *
     * @param  \App\Connection
     * @return array
     */
    public function getConnectionCompanySelectDefault(Connection $connection) {
      $company = array();
      $cw_company = $this->connectwise->get('company/companies', ['id = ' . $connection->cw_company_id]);
      if (!is_null($cw_company)) {
        $company = array($cw_company[0]->id => $cw_company[0]->name);
      }
      return $company;
    }

    /**
     * return cw agreement for connection.
     *
     * @param  \App\Connection
     * @return array
     */
    public function getConnectionAgreementSelectDefault(Connection $connection) {
      $agreement = array();
      $cw_agreement = $this->connectwise->get('finance/agreements', ['id = ' . $connection->cw_agreement]);
      if (!is_null($cw_agreement)) {
        $agreement = array($cw_agreement[0]->id => $cw_agreement[0]->name);
      }
      return $agreement;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Connection $connection, ConnectionRequest $request)
    {
      $connection->update($request->all());
      return redirect("connections/{$connection->id}")->with([
        'message' => "Connection \"{$connection->jira_project_key}\" has been updated",
        'alert-class' => "alert-success"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Connection $connection)
    {
      $connection->delete();
      return redirect('connections')->with([
        'message' => "Connection \"{$connection->jira_project_key}\" has been deleted",
        'alert-class' => "alert-warning"
        ]);
    }

    /**
     * Intercept jira data sent via webhooks.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function jiraPost(Request $request)
    {
      $data = $request->getContent();
      return $request->timestamp;
      $data_arr = json_encode(json_decode($data));
      var_export($data_arr);
    }

    /**
     * Display json object of cw companies.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function findCwCompanies(Request $request)
    {
      $q = empty($request->all()['q']) ? '' : $request->all()['q'];
      $companies = $this->connectwise->get('company/companies', ['name like "' . $q . '*"']);
      return $companies;
    }

     /**
     * Display json object of cw agreements.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function findCwAgreements(Request $request)
    {
      $q = empty($request->all()['q']) ? '' : $request->all()['q'];
      $agreements = $this->connectwise->get('finance/agreements', ['company/id = ' . $q]);
      return $agreements;
    }

    /**
     * Display json object of cw agreements.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getCwServiceBoards()
    {
      $expires = Carbon::now()->addWeek();
      $agreements = Cache::remember('cw_service_boards', $expires, function () {
          return $this->connectwise->get('service/boards');
      });
      return $agreements;
    }

    /**
     * Display json object of cw agreements.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getCwServicePriorities()
    {
      $expires = Carbon::now()->addWeek();
      $priorities = Cache::remember('cw_service_priorities', $expires, function () {
          return $this->connectwise->get('service/priorities');
      });
      return $priorities;
    }

    /**
     * Display json object of jira projects
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getJiraProjects(Request $request, Setting $setting) {
      $expires = Carbon::now()->addWeek();
      $projects = Cache::remember('jira_projects', $expires, function () {
          return $this->jira->get('project');
      });

      if ($q = empty($request->all()['q']) ? '' : $request->all()['q']) {
        $projects = array_filter($projects, function($var) use ($q){
          return strpos(strtolower($var->name), strtolower($q)) !== FALSE;
        });
      }
      return $projects;
    }

  }
