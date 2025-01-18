<?php

namespace App\Http\Controllers;

use App\Models\Sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
   public function index()
   {
       if(Auth::user()->hasRole('user')){
          return view('userdash');
       } 
       else {
          return view('dashboard');
     }
   }

   public function aboutUs()
   {
      return view('worker.views.home.about-us');
   }

   public function profile()
   {
      return view('profile');
   }

   public function home()
   {
      $mainImageSection = Sections::where('section_name', "main-image-section")->get();

      $sliderSection = Sections::where('page', "slider")->get();

      $thirdSection = Sections::where('section_name', "after-slider-section")->get();

      $isMobile = $this->isMobileDev();
      
      return view('worker.views.home.home',['mainImageSection' => $mainImageSection, 'sliderSection' => $sliderSection, 'thirdSection' => $thirdSection, 'isMobile' => $isMobile]);
   }

   private function isMobileDev(){
      if(!empty($_SERVER['HTTP_USER_AGENT'])){
         $user_ag = $_SERVER['HTTP_USER_AGENT'];
         if(preg_match('/(Mobile|Android|Tablet|GoBrowser|[0-9]x[0-9]*|uZardWeb\/|Mini|Doris\/|Skyfire\/|iPhone|Fennec\/|Maemo|Iris\/|CLDC\-|Mobi\/)/uis',$user_ag)){
            return true;
         };
      };
      return false;
  }
}
