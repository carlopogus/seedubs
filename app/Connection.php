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

    /**
     * Setup connectwise creds.
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $settings = Setting::pluck('value', 'name');
        $this->connectWise = new Providers\ConnectwiseProvider(array('cw_host' => $settings['cw_host']));
        $this->connectWise->useSSL(FALSE);
        $this->connectWise->setCWHost($settings['cw_host']);
        $this->connectWise->setCOID($settings['cw_COID']);
        $this->connectWise->setUsername($settings['cw_username']);
        $this->connectWise->setPassword($settings['cw_password']);
        $this->connectWise->cw_release = $settings['cw_release'];
        $this->connectWise->api_version = $settings['cw_api_version'];

        // $comp = $this->getCompanyById('19732');
    }

    public function getCompanyById($companyId)
    {
        $action = 'GetCompany';
        $this->connectWise->setAction($action);
        $this->connectWise->setParameters(array(
            'id' => $companyId,
        ));
        $results = json_decode(json_encode($this->connectWise->makeCall()), FALSE);
        if (!$data = $results->{$action . 'Response'}->{$action . 'Result'}) {
            return null;
        }
        return $data;
    }

}
