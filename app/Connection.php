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
        'cw_agreement',
        'cw_company_id',
        'cw_service_board',
        'cw_ticket_priority',
    ];

    private $connectWise;

    /**
     * Setup connectwise creds.
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $settings = Setting::pluck('value', 'name');
        $init_vars = array('cw_host' => $settings['cw_host']);
        $this->connectWise = new Providers\ConnectwiseProvider($init_vars);
        $this->connectWise->setCWHost($settings['cw_host']);
        $this->connectWise->setCOID($settings['cw_COID']);
        $this->connectWise->setUsername($settings['cw_username']);
        $this->connectWise->setPassword($settings['cw_password']);
        $this->connectWise->cw_release = $settings['cw_release'];
        $this->connectWise->api_version = $settings['cw_api_version'];

        // $comp = $this->getCompanyById('19732');
        // dd($comp);
    }

    public function FindCompanies($company, $limit = 10) {
      $action = 'FindCompanies';
      $this->connectWise->setAction($action);
      $options = array(
        'conditions' => 'CompanyName like "%' . $company . '%"',
        'limit' => $limit,
        );
      $this->connectWise->setParameters($options);
      $results = json_decode(json_encode($this->connectWise->makeCall()), FALSE);
      if (!$data = $results->{$action . 'Response'}->{$action . 'Result'}) {
        return null;
      }
      return $data->CompanyFindResult;
    }

    public function FindAgreements($companyId, $limit = 10) {
      $action = 'FindAgreements';
      $this->connectWise->setAction($action);
      $options = array(
        'conditions' => 'CompanyId = ' . $companyId,
        'limit' => $limit,
        );
      $this->connectWise->setParameters($options);
      $results = json_decode(json_encode($this->connectWise->makeCall()), FALSE);
      if (!$data = $results->{$action . 'Response'}->{$action . 'Result'}) {
        return null;
      }
      return $data->AgreementFindResult;
    }

    public function GetAgreement($id) {
      $data = null;
      $action = 'GetAgreement';
      $this->connectWise->setAction($action);
      $options = array(
        'id' => $id
      );
      $this->connectWise->setParameters($options);
      $results = json_decode(json_encode($this->connectWise->makeCall()), FALSE);
      if (!empty($results->{$action . 'Response'}->{$action . 'Result'})) {
            $data = $results->{$action . 'Response'}->{$action . 'Result'};
        }
      return $data;
    }

    public function getCompanyById($companyId)
    {
        $data = null;
        $action = 'GetCompany';
        $this->connectWise->setAction($action);
        $this->connectWise->setParameters(array(
            'id' => $companyId,
        ));
        $results = json_decode(json_encode($this->connectWise->makeCall()), FALSE);
        if (!empty($results->{$action . 'Response'}->{$action . 'Result'})) {
            $data = $results->{$action . 'Response'}->{$action . 'Result'};
        }
        return $data;
    }

}
