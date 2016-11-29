<?php

use Illuminate\Database\Seeder;


class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      $rows = array(
        'cw_host' => array(
          'value' => '',
          'name' => 'Connectwise Host URL',
          'description' => ''
        ),
        'cw_release' => array(
          'value' => '',
          'name' => 'Connectwise API Release',
          'description' => ''
        ),
        'cw_api_version' => array(
          'value' => '',
          'name' => 'Connectwise API Version',
          'description' => ''
        ),
        'cw_COID' => array(
          'value' => '',
          'name' => 'Connectwise Company ID',
          'description' => ''
        ),
        'cw_api_key' => array(
          'value' => '',
          'name' => 'Connectwise API Key',
          'description' => ''
        ),
        'cw_api_secret' => array(
          'value' => '',
          'name' => 'Connectwise API Secret',
          'description' => ''
        ),
        // 'cw_username' => array(),
        // 'cw_password' => array(),
        'jira_host' => array(
          'value' => '',
          'name' => 'Jira Host URL',
          'description' => ''
        ),
        'jira_api_version' => array(
          'value' => '',
          'name' => 'Jira API Version',
          'description' => ''
        ),
        'jira_username' => array(
          'value' => '',
          'name' => 'Jira Username',
          'description' => ''
        ),
        'jira_password' => array(
          'value' => '',
          'name' => 'Jira Password',
          'description' => ''
        ),
        'jira_cw_field' => array(
          'value' => '',
          'name' => 'Jira Connectwise Field',
          'description' => ''
        ),
      );

      foreach ($rows as $row => $values) {
        $exists = App\Setting::where('key', $row)->exists();
        if (!$exists) {
          DB::table('settings')->insert([
            'key' => $row,
            'value' => $values['value'],
            'name' => $values['name'],
          ]);
        }
      }
    }
}
