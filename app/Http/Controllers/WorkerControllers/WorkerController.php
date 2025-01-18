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

   public function personalData()
   {
      $company_data = Company_Data::where('worker_id', Helper::worker())->first();
      return view('worker.views.profile.personal-data', ['company_data' => $company_data ?? null]);
   }
   public function savePersonalData(Request $request)
   {
         $data = $request->validate([
            'company_name' => 'required | max:50 | regex:/\p{L}/u',
            'country' => 'required | max:20 | regex:/\p{L}/u',
            'city' => 'required | max:30 | regex:/\p{L}/u',
            'postcode' => 'required | max:10 | regex:/^[0-9]+$/',
            'address' => 'required | max:50 | regex:/\p{L}/u',
            'email' => 'required | email',
            'phone' => 'required | max:25 | regex:/^([0-9\s\-\+\(\)]*)$/',
            'pib' => 'required | max:20 | regex:/^[0-9\-]+$/',
            'maticni_broj' => 'required | max:25 | regex:/^[0-9\-]+$/',
            'tekuci_racun' => 'required | max:30 | regex:/^[0-9\-]+$/',
            'bank_name' => 'required | max:30 | regex:/\p{L}/u',
            'logo' => 'required | mimes:jpeg,png,jpg,webp | max:2048 ',
         ],
         [
            'naziv_firme' => trans("app.errors.profile-company"),
            '*.required' => trans("app.errors.profile-required"),
            'logo.mimes' => trans("app.errors.profile-image"),
            'logo.max' => trans("app.errors.profile-image-max"),
            'postcode.regex' => trans("app.errors.profile-only-numbers"),
            'pib.regex' => trans("app.errors.profile-only-numbers"),
            'maticni_broj.regex' => trans("app.errors.profile-only-numbers"),
            'tekuci_racun.regex' => trans("app.errors.profile-only-numbers"),
            'email.email' => trans("app.errors.profile-email"),
         ]);

      $user_id = Auth::guard('worker')->user()->id;

      if(Company_Data::where('worker_id', $user_id)->first() == null)
      {
         $fileName = null;
         if ($data['logo'] != null) {
            $image = Image::make($data['logo'])->encode('webp', 90)->resize(360, 270);
            $name = uniqid().'.webp';
            Storage::disk('public')->put('images/worker/'.$user_id .'/logo'. '/' . $name, $image);
            $path = 'images/worker/'.$user_id .'/logo'. '/' . $name;
         }

         $company_data = Company_Data::create([
            'worker_id' => Helper::worker(),
            'company_name' => [
               'sr' => Helper::transliterate($data['company_name'],"sr"),
               'rs-cyrl' => Helper::transliterate($data['company_name'],"rs-cyrl")
            ],
            'country' => [
               'sr' => Helper::transliterate($data['country'],"sr"),
               'rs-cyrl' => Helper::transliterate($data['country'],"rs-cyrl")
            ],
            'city' => [
               'sr' => Helper::transliterate($data['city'],"sr"),
               'rs-cyrl' => Helper::transliterate($data['city'],"rs-cyrl")
            ],
            'zip_code' => $data['postcode'],
            'address' => [
               'sr' => Helper::transliterate($data['address'],"sr"),
               'rs-cyrl' => Helper::transliterate($data['address'],"rs-cyrl")
            ],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'pib' => $data['pib'],
            'maticni_broj' => $data['maticni_broj'],
            'tekuci_racun' => $data['tekuci_racun'],
            'bank_name' => $data['bank_name'],
            'logo' => $path,
         ]);

         if($company_data->wasRecentlyCreated){
            alert()->success(__('app.controllers.data-is-saved'))->showCloseButton()->showConfirmButton(__('app.basic.close'));
            if (session('ponuda_id') != null) {
               return redirect()->route('worker.archive.genarte.tamplate.pdf.create');
            }
            return redirect()->route('worker.personal.data');
         }
      }
      alert()->error(__('app.controllers.data-is-not-saved'))->showCloseButton()->showConfirmButton(__('app.basic.close'));
      return redirect()->route('worker.personal.data');
   }

   public function companyDelete()
   {
      $company_data = Company_Data::where('worker_id', Helper::worker())->first();
      Storage::disk('public')->delete($company_data->logo);
      $company_data->delete();
      return redirect()->route('worker.personal.data');
   }

   public function myContacts()
   {
      $fizicka_lica = Fizicko_Lice::where('worker_id', Helper::worker())->get();
      $pravna_lica = Pravno_Lice::where('worker_id', Helper::worker())->get();
      return view('worker.views.profile.profile-contacts', ['fizicka_lica' => $fizicka_lica, 'pravna_lica'=> $pravna_lica]);
   }

   public function addFizickoIndex()
   {
      return view('worker.views.profile.add-fizicko-lice');
   }

   public function saveFizickoLice(Request $request)
   {
      $data = $request->validate([
            'f_name' => 'required | max:30 | regex:/\p{L}/u',
            'l_name' => 'required | max:30 | regex:/\p{L}/u',
            'city' => 'required | max:30 | regex:/\p{L}/u',
            'postcode' => 'required | max:10 | regex:/^[0-9]+$/',
            'address' => 'required | max:50 | regex:/\p{L}/u',
            'email' => 'required | email',
            'id' => ['nullable','exists:App\Models\Fizicko_lice,id'],
            'phone' => 'required | max:25 | regex:/^([0-9\s\-\+\(\)]*)$/'
         ],
         [
            '*.required' => trans("app.errors.profile-required"),
            'postcode.regex' => trans("app.errors.profile-only-numbers"),
            'email.email' => trans("app.errors.profile-email"),
         ]);

      $id = $data['id'] ?? null;

      $fizicko_lice = Fizicko_lice::updateOrCreate(
         [
            'worker_id' => Helper::worker(),
            'id' => $id
         ],
         [
         'worker_id' => Helper::worker(),
         'first_name' => [
            'sr' => Helper::transliterate($data['f_name'],"sr"),
            'rs-cyrl' => Helper::transliterate($data['f_name'],"rs-cyrl")
         ],
         'last_name' => [
            'sr' => Helper::transliterate($data['l_name'],"sr"),
            'rs-cyrl' => Helper::transliterate($data['l_name'],"rs-cyrl")
         ],
         'city' => [
            'sr' => Helper::transliterate($data['city'],"sr"),
            'rs-cyrl' => Helper::transliterate($data['city'],"rs-cyrl")
         ],
         'zip_code' => $data['postcode'],
         'address' => [
            'sr' => Helper::transliterate($data['address'],"sr"),
            'rs-cyrl' => Helper::transliterate($data['address'],"rs-cyrl")
         ],
         'email' => $data['email'],
         'phone' => $data['phone']
      ]);

      if($fizicko_lice->wasRecentlyCreated){
         alert()->success(__('app.basic.successfully-added'))->showCloseButton()->showConfirmButton(__('app.basic.close'));
      } elseif($fizicko_lice->wasChanged()) {
         alert()->success(__('app.controllers.data-is-changed'))->showCloseButton()->showConfirmButton(__('app.basic.close'));
      }
      elseif(!$fizicko_lice) {
         alert()->error(__('app.controllers.data-is-not-saved-or-changed'))->showCloseButton()->showConfirmButton(__('app.basic.close'));
      }
      else{
         alert()->success(__('app.controllers.data-is-changed'))->showCloseButton()->showConfirmButton(__('app.basic.close'));
      }
      return redirect()->route('worker.personal.contacts')->with('selected_fizicko', 'fizicko_lice');
   }

   public function editContactFizicka($id)
   {
      //validator
      $data = ['id' => $id];
      $rules = [
          'id' => ['required', 'exists:App\Models\Fizicko_lice,id'],
      ];
      $validator = Validator::make($data, $rules);
      if ($validator->fails()) {
          return redirect()->back()->withErrors($validator);
      }

      $contact = Fizicko_lice::where('id', $id)->where('worker_id', Helper::worker())->first();
      return view('worker.views.profile.add-fizicko-lice', ['contact' => $contact]);
   }

   public function deleteContactFizicka(Request $request)
   {
      $request->validate([
         'id' => ['required','exists:App\Models\Fizicko_lice,id']
      ]);

      Fizicko_lice::where('id', $request->input('id'))->where('worker_id', Helper::worker())->delete();
      alert()->success(__('app.controllers.contact-is-deleted'))->showCloseButton()->showConfirmButton(__('app.basic.close'));
      return redirect()->route('worker.personal.contacts');
   }

   public function addPravnoIndex()
   {
      return view('worker.views.profile.add-pravno-lice');
   }

   public function savePravnoLice(Request $request)
   {
      $data = $request->validate([
         'company_name' => 'required | max:50 | regex:/\p{L}/u',
         'city' => 'required | max:30 | regex:/\p{L}/u',
         'postcode' => 'required | max:10 | regex:/^[0-9]+$/',
         'address' => 'required | max:50 | regex:/\p{L}/u',
         'email' => 'required | email',
         'id' => ['nullable','exists:App\Models\Pravno_lice,id'],
         'phone' => 'required | max:25 | regex:/^([0-9\s\-\+\(\)]*)$/',
         'pib' => 'max:30 | regex:/^[0-9\-]+$/',
      ],
      [
         '*.required' => trans("app.errors.profile-required"),
         'postcode.regex' => trans("app.errors.profile-only-numbers"),
         'email.email' => trans("app.errors.profile-email"),
         'pib.regex' => trans("app.errors.profile-only-numbers"),
      ]);

      $id = $data['id'] ?? null;

      $pravno_lice = Pravno_lice::updateOrCreate(
         [
            'worker_id' => Helper::worker(),
            'id' => $id
         ],
         [
         'worker_id' => Helper::worker(),
         'company_name' => [
            'sr' => Helper::transliterate($data['company_name'],"sr"),
            'rs-cyrl' => Helper::transliterate($data['company_name'],"rs-cyrl")
         ],
         'city' => [
            'sr' => Helper::transliterate($data['city'],"sr"),
            'rs-cyrl' => Helper::transliterate($data['city'],"rs-cyrl")
         ],
         'zip_code' => $data['postcode'],
         'address' => [
            'sr' => Helper::transliterate($data['address'],"sr"),
            'rs-cyrl' => Helper::transliterate($data['address'],"rs-cyrl")
         ],
         'email' => $data['email'],
         'phone' => $data['phone'],
         'pib' => $data['pib'],
      ]);

      if($pravno_lice->wasRecentlyCreated){
         alert()->success(__('app.basic.successfully-added'))->showCloseButton()->showConfirmButton(__('app.basic.close'));
      } elseif($pravno_lice->wasChanged()) {
         alert()->success(__('app.controllers.data-is-changed'))->showCloseButton()->showConfirmButton(__('app.basic.close'));
      }
      else{
         alert()->error(__('app.controllers.data-is-not-saved-or-changed'))->showCloseButton()->showConfirmButton(__('app.basic.close'));
      }
      return redirect()->route('worker.personal.contacts')->with('selected_pravna', 'pravno_lice');
   }

   public function editContactPravno($id)
   {
      //validator
      $data = ['id' => $id];
      $rules = [
            'id' => ['required','exists:App\Models\Pravno_lice,id'],
      ];
      $validator = Validator::make($data, $rules);
      if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
      }
      
      return view('worker.views.profile.add-pravno-lice', ['contact' => Pravno_lice::where('id', $id)->where('worker_id', Helper::worker())->first()]);
   }

   public function deleteContactPravno(Request $request)
   {
      $request->validate([
         'id' => ['required','exists:App\Models\Pravno_lice,id']
      ]);
      
      Pravno_lice::where('id', $request->input('id'))->where('worker_id', Helper::worker())->delete();
      return redirect()->route('worker.personal.contacts');
   }

   public function profileSettingsCreate()
   {
      return view('worker.views.profile.profile-settings');
   }
    
   public function updatePassword(Request $request)
   {
      $request->validate([
         'old_password' => 'required',
         'new_password' => ['required','string','confirmed', 
            Password::min(8)
               ->mixedCase()
               ->numbers()
         ],
      ],
      [
         'new_password' => trans("app.errors.new_password"),
         '*.required' => trans("app.errors.profile-required"),
      ]);

      if(!Hash::check($request->old_password, auth('worker')->user()->password)){
         alert()->error(__('app.controllers.old-password-not-matching'))->showCloseButton()->showConfirmButton(__('app.basic.close'));
         return redirect()->back();
      }
      Worker::whereId(Helper::worker())->update([
            'password' => Hash::make($request->new_password)
      ]);

      alert()->success(__('app.controllers.password-is-changed'))->showCloseButton()->showConfirmButton(__('app.basic.close'));
      return redirect()->back();
   }

   public function setupProfile(Request $request)
   {
      $request->validate(
      [
         'skini' => 'required|in:1,2',
         'posalji' => 'required|in:1,2',
      ]);

      $worker = auth('worker')->user();
      if($request->skini == 1)
      {
         $worker->send_email_on_download = false;
      }
      elseif($request->skini == 2)
      {
         $worker->send_email_on_download = true;
      }

      if($request->posalji == 1)
      {
         $worker->send_email_on_send = false;
      }
      elseif($request->posalji == 2)
      {
         $worker->send_email_on_send = true;
      }

      $worker->save();

      return redirect()->back();
   }

   public function showContact($lice,$id) {
      //validator
      $data = ['id' => $id, 'lice' => $lice];
      $rules = [
         'id' => [
            'required', 
            function ($attribute, $value, $fail) {
               if (!Fizicko_lice::where('id', $value)->exists() && !Pravno_lice::where('id', $value)->exists()) {
                  $fail('The selected :attribute is invalid.');
               }
            },
         ],
         'lice' => ['required', 'in:individual,legal-entity'],
      ];
      $validator = Validator::make($data, $rules);
      if ($validator->fails()) {
          return redirect()->back()->withErrors($validator);
      }

      if ($lice == 'individual') {
         $contact = Fizicko_lice::where('id', $id)->where('worker_id', Helper::worker())->first();
         return view('worker.views.profile.show-contact', ['contact' => $contact, 'lice'=> $lice]);
      }

      if ($lice == 'legal-entity') {
         $contact = Pravno_lice::where('id', $id)->where('worker_id', Helper::worker())->first();
         return view('worker.views.profile.show-contact', ['contact' => $contact, 'lice'=> $lice]);
      }
   }
   public function editUser(Request $request) {
        $request->validate([
          'phone' => 'required|string|max:20|regex:/^([0-9\s\-\+\(\)]*)$/|min:9',
          'user_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', 
          'cv' => ['nullable','string','max:2048'],
        ]);
        $phone = $request->input('phone');
        $cv = $request->input('cv');
        $fileName = null;
        if ($request->hasFile('user_image')) {
          if(Auth::guard('worker')->user()->image !== null)
          {
            $path = 'public/workers/avatars/' . Auth::guard('worker')->user()->image;
            if (Storage::exists($path)) {
              Storage::delete($path);
            }
          }
          $image = $request->file('user_image');
          $fileName = uniqid().time() . '.' . $image->getClientOriginalExtension();
          $img = Image::make($image->getRealPath());
          $img->stream();
          Storage::disk('local')->put('public/workers/avatars/'.$fileName, $img, 'public');
          Worker::whereId(Helper::worker())->update(['phone' => $phone, 'image' => $fileName, 'cv' => $cv]);
        }
        else
        {
          Worker::whereId(Helper::worker())->update(['phone' => $phone, 'cv' => $cv]);
        }
        Alert::success('Your data is successfully updated')->showCloseButton()->showConfirmButton('Aight');
        return redirect()->back();
    }

    public function catalogueCategories()
    {
      $custom_work_types = Default_work_type::select(
            'work_types.id',
            'work_types.name',
            "c.work_type_id AS merged_id"
         )
         ->leftJoin('categories as c', 'c.work_type_id', '=', 'work_types.id')
         ->distinct()
         ->get();

      $custom_categories = Default_category::select(
            'categories.id',
            'categories.name',
            'categories.work_type_id',
            "sc.category_id AS merged_id"
         )
         ->leftJoin('subcategories as sc', 'sc.category_id', '=', 'categories.id')
         ->distinct()
         ->get();

      $custom_subcategories = Default_subcategory::select('subcategories.id','subcategories.name','subcategories.category_id',
            "p.subcategory_id AS merged_id"
         )
         ->leftJoin('pozicija as p', 'p.subcategory_id', '=', 'subcategories.id')
         ->distinct()
         ->get();

         $custom_pozicije = Default_pozicija::select('id','title','subcategory_id')->get();

      return view('worker.views.catalogue-categories', compact(['custom_categories','custom_subcategories','custom_pozicije','custom_work_types']));
    }
}
