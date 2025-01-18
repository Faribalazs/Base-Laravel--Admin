<?php

namespace App\Http\Controllers;

use App\Models\{User,Worker,Admin,Default_category, Default_subcategory, Default_pozicija, Units, Tracker, Sections, FreeTrial, Premium};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class AdminController extends Controller
{
  public function dashboard()
  {
    $active = Tracker::where('visit_date', date('Y-m-d'))->where('visit_time', '>=', now()->subMinutes(5)->toTimeString())->distinct('worker_id')->count();
    $workers = Tracker::where('visit_date', date('Y-m-d'))->distinct('worker_id')->count();
    $workers_last_30_days = Tracker::where('visit_date', '>', now()->subDays(30)->endOfDay())->distinct('worker_id')->count();
    $max_visit = Tracker::where('visit_date', date('Y-m-d'))->orderByDesc('hits')->first();
    $overall_visit_today = Tracker::where('visit_date', date('Y-m-d'))->sum('hits');
    $overall_visit_last_30_days = Tracker::where('visit_date', '>', now()->subDays(30)->endOfDay())->sum('hits');
    $diff_ip = Tracker::where('visit_date', date('Y-m-d'))->distinct('ip')->count();
    $diff_ip_last_30_days = Tracker::where('visit_date', '>', now()->subDays(30)->endOfDay())->distinct('ip')->count();

    $browserType = Tracker::select('browser')->where('visit_date', date('Y-m-d'))->count();
    $deviceType = Tracker::select('device')->where('visit_date', date('Y-m-d'))->count();

    $unknown_browser = $this->browser('unknown');
    $chrome = $this->browser('chrome');
    $firefox = $this->browser('firefox');
    $opera = $this->browser('opera');
    $safari = $this->browser('safari');
    $ie = $this->browser('ie');
    $edge = $this->browser('edge');

    $unknown_device = $this->device('unknown');
    $desktop = $this->device('desktop');
    $mobile = $this->device('mobile');
    $tablet = $this->device('tablet');
    $bot = $this->device('bot');

    return view('admin.views.admin-dash',compact(['active','workers','workers_last_30_days','max_visit',
          'overall_visit_today','overall_visit_last_30_days',
          'diff_ip','diff_ip_last_30_days',
          'browserType','deviceType',
          'unknown_browser', 'chrome', 'firefox', 'opera', 'safari', 'ie', 'edge',
          'unknown_device', 'desktop', 'mobile', 'tablet', 'bot'
        ]));
  }

  private function browser($browser)
  {
    return Tracker::where('browser', $browser)->where('visit_date', date('Y-m-d'))->count();
  }

  private function device($device)
  {
    return Tracker::where('device', $device)->where('visit_date', date('Y-m-d'))->count();
  }

  public function insertAdmin()
  {
    $user = Worker::create([
      'first_name' => 'Pista',
      'last_name' => 'Kovacs',
      'email' => 'test@test.com',
      'password' => Hash::make('testpass'),
      'email_verified_at' => '2023-05-03',
      'image' => null,
      'cv'  => 'Opis majstora cime se bavim i takve stavri',
      'phone' => '0645871325',
    ]);

    $user->attachRole('super_worker'); 
    event(new Registered($user));

    $user = Worker::create([
      'first_name' => 'Pista',
      'last_name' => 'Kovacs',
      'email' => 'worker@worker.com',
      'password' => Hash::make('worker'),
      'email_verified_at' => '2023-05-03',
      'image' => null,
      'cv'  => 'Opis majstora cime se bavim i takve stavri',
      'phone' => '0645871325',
    ]);

    $user->attachRole('worker'); 
    event(new Registered($user));

    $user = Admin::create([
      'name' => 'Admin',
      'email' => 'admin@admin.com',
      'password' => Hash::make('admin123'),
      'email_verified_at' => '2023-05-03',
      'image' => null,
    ]);
    $user->attachRole('admin');
    event(new Registered($user));
  }

  public function create()
  {
      return view('admin.views.admin-profile');
  }

  public function sectionsCreate()
  {
    $sections = Sections::paginate(15);

    return view('admin.views.show-sections', ['sections' => $sections]);
  }

  public function sectionsEdit($id)
  {
    $section = Sections::where('id', $id)->get();

    return view('admin.views.edit-sections', ['section' => $section]);
  }

  public function sectionsEditDone($id, Request $request)
  {
    $sections = Sections::where('id', $id)->first();
    $sections->update([
      'page' => $request->page,
      'section_name' => $request->section_name,
      'order' => $request->order,
      'section_number' => $request->section_number,
    ]);

    $locale = app()->getLocale();

    $sections->setTranslations('title', [$locale => $request->input('title')]);
    $sections->setTranslations('content', [$locale => $request->input('content')]);
    $sections->setTranslations('btn_text', [$locale => $request->input('btn_text')]);
    $sections->setTranslations('btn_link', [$locale => $request->input('btn_link')]);

    $sections->save();

    return view('admin.views.edit-sections', ['section' => Sections::where('id', $id)->get()]);
  }

  public function sectionsDelete(Request $request){
    Sections::where('id', $request->input('id'))->delete();
    return redirect()->back();
  }
}