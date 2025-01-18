<?php

namespace App\Http\Controllers\WorkerControllers;

use App\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Intervention\Image\Facades\Image as Image;
use App\Models\{Company_Data,Fizicko_lice,Pravno_lice,Worker,Default_category,Default_subcategory,Default_pozicija,Default_work_type};
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class WorkerController extends Controller
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

   public function profile()
   {
      return view('worker.views.profile.profile-page');
   }
}
