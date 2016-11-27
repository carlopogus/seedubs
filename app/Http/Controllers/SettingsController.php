<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Setting;
use Illuminate\Support\Facades\Cache;

class SettingsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
      $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $settings = Setting::all();
      // dd($settings);
      return view('admin.settings.index', compact('settings'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request)
    {
      $settings = $request->except('_token');

      foreach ($settings as $name => $value) {
        $setting = Setting::key($name)->first();
        $setting->value = $value;
        $setting->save();
      }

      return redirect('settings/api')->with([
        'message' => "Settings have been updated.",
        'alert-class' => "alert-success"
        ]);
    }

    public function performance()
    {
      return view('admin.settings.performance');
    }

    public function clearCache()
    {
      Cache::flush();
      return redirect('settings/performance')->with([
        'message' => "All caches have been cleared",
        'alert-class' => "alert-success"
        ]);
    }

  }
