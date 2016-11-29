<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Http\Requests\ConnectionRequest;
use Illuminate\Http\Request;
use App\Connection;
use Illuminate\Support\Facades\Cache;
use App\Setting;

class ConnectionsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $company = array();
      $agreement = array();
      $project = array();
      return view('admin.connections.create', compact('company', 'agreement', 'project'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ConnectionRequest $request)
    {
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

      $cw_company = $connection->getCompanyById($connection->cw_company_id);
      if (!is_null($cw_company)) {
        $connection->cw_company_name = $cw_company->CompanyName;
      }
      $cw_agreement = $connection->getAgreement($connection->cw_agreement);
      if (!is_null($cw_agreement)) {
        $connection->cw_agreement_name = $cw_agreement->AgreementName;
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
      $boards = $this->getConnectionServiceBoardSelectDefault($connection);
      return view('admin.connections.edit', compact('connection', 'company', 'agreement', 'project'));
    }

    /**
     * return cw company for connection.
     *
     * @param  \App\Connection
     * @return array
     */
    public function getConnectionServiceBoardSelectDefault(Connection $connection) {
      $boards = array();
      $cw_company = $connection->getCompanyById($connection->cw_company_id);
      if (!is_null($cw_company)) {
        $company = array($cw_company->Id => $cw_company->CompanyName);
      }
      return $company;
    }

    /**
     * return cw company for connection.
     *
     * @param  \App\Connection
     * @return array
     */
    public function getConnectionCompanySelectDefault(Connection $connection) {
      $company = array();
      $cw_company = $connection->getCompanyById($connection->cw_company_id);
      if (!is_null($cw_company)) {
        $company = array($cw_company->Id => $cw_company->CompanyName);
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
      $cw_agreement = $connection->getAgreement($connection->cw_agreement);
      if (!is_null($cw_agreement)) {
        $agreement = array($cw_agreement->Id => $cw_agreement->AgreementName);
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
        // var_export($data);
      $data_arr = json_encode(json_decode($data));
      var_export($data_arr);
    }

    /**
     * Display json object of cw companies.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function findCompanies(Request $request)
    {
      $q = empty($request->all()['q']) ? '' : $request->all()['q'];
      $connection = new Connection;
      $companys = $connection->FindCompanies($q, 10);
      return response()->json($companys);
    }

    /**
     * Display json object of cw agreements.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function findAgreements(Request $request)
    {
      $q = empty($request->all()['q']) ? '' : $request->all()['q'];
      $connection = new Connection;
      $companys = $connection->FindAgreements((int)$q, 10);
      return response()->json($companys);
    }

    /**
     * Display json object of jira projects
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function jiraProjects(Request $request, Setting $setting) {
      $projects = $setting->getJiraProjects();
      if ($q = empty($request->all()['q']) ? '' : $request->all()['q']) {
        $projects = array_filter($projects, function($var) use ($q){
          return strpos(strtolower($var->name), strtolower($q)) !== FALSE;
        });
      }
      return $projects;
    }

  }
