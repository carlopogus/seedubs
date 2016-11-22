<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Http\Requests\ConnectionRequest;
use Illuminate\Http\Request;
use App\Connection;

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
        return view('admin.connections.create', compact('company', 'agreement'));
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
            'flash_message' => TRUE,
            'flash_message_success' => "Connection \"{$request->all()['jira_project_key']}\" has been created"
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
        $company = array();
        $agreement = array();
        $cw_agreement = $connection->getAgreement($connection->cw_agreement);
        $cw_company = $connection->getCompanyById($connection->cw_company_id);
        if (!is_null($cw_company)) {
            $company = array($cw_company->Id => $cw_company->CompanyName);
        }
        if (!is_null($cw_agreement)) {
            $agreement = array($cw_agreement->Id => $cw_agreement->AgreementName);
        }
        return view('admin.connections.edit', compact('connection', 'company', 'agreement'));
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
            'flash_message' => TRUE,
            'flash_message_success' => "Connection \"{$connection->jira_project_key}\" has been updated"
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
            'flash_message' => TRUE,
            'flash_message_danger' => "Connection \"{$connection->jira_project_key}\" has been deleted"
        ]);
    }

        /**
     * Store a newly created resource in storage.
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

    public function findCompanies(Request $request)
    {
        $q = empty($request->all()['q']) ? '' : $request->all()['q'];
        $connection = new Connection;
        $companys = $connection->FindCompanies($q, 10);
        return response()->json($companys);
    }

    public function findAgreements(Request $request)
    {
        $q = empty($request->all()['q']) ? '' : $request->all()['q'];
        $connection = new Connection;
        $companys = $connection->FindAgreements((int)$q, 10);
        return response()->json($companys);
    }
}
