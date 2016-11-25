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
        'cw_host',
        'cw_release',
        'cw_api_version',
        'cw_COID',
        'cw_username',
        'cw_password',
        'jira_host',
        'jira_api',
        'jira_username',
        'jira_password',
        'jira_cw_field',
      );

      foreach ($rows as $row) {
        $exists = App\Setting::where('name', $row)->exists();
        if (!$exists) {
          DB::table('settings')->insert([
            'name' => $row,
            'value' => '',
          ]);
        }
      }
    }
}
