<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Setting;

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
          \DB::table('settings')
            ->where('name', $name)
            ->update(['value' => $value]);
        }

        // dd($request->except('_token'));
        // $article = Article::findOrFail($id);
        // $article->update($request->all());
        // return redirect()->route('settings', compact('id'));

        return redirect('admin/settings')->with([
            'message' => "Settings have been updated.",
            'alert-class' => "alert-success"
        ]);
    }
}
