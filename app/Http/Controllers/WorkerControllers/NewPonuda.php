<?php

namespace App\Http\Controllers\WorkerControllers;

use App\Models\{Ponuda, Category, Subcategory, Pozicija, Default_category, Default_subcategory, Default_pozicija, Swap, Title_Temporary, Pozicija_Temporary, Ponuda_Date, Worker, Default_work_type, Work_type};
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use App\Helpers\Helper;
use App\Rules\CheckID;
use Illuminate\Support\Facades\Validator;

class NewPonuda extends Controller
{
   public function create()
   {  
      $worker_id = Helper::worker();
      $mergedData = $this->mergedData($worker_id);

      $work_types = Default_work_type::all();
      $custom_work_types = Work_type::where('worker_id', $worker_id)
      ->whereNull('is_work_type_deleted')
      ->get();

      $swap = Swap::join('workers', 'swap_ponuda.worker_id', '=', 'workers.id')
         ->where('workers.id', $worker_id)
         ->get();  

      return view('worker.views.create-ponuda',  compact(['mergedData','swap','work_types','custom_work_types']));
   }

   //Get Categories for Vue axios endpoint
   public function getCategoriesFromId($id, $worker_id) 
   {
      $data = ['id' => $id];
      $rules = [
         'id' => ['required', new CheckID(Default_category::class, Category::class)],
      ];
      $validator = Validator::make($data, $rules);
      if ($validator->fails()) {
         return redirect()->back()->withErrors($validator);
      }

      if($worker_id == Helper::worker())
      {
         $default_categories = Default_category::where('work_type_id', $id)->get();

         $custom_categories = Category::where('worker_id', $worker_id)->where('custom_work_type_id', $id)
            ->whereNull('is_category_deleted')
            ->get();
         
         $categories = $default_categories->merge($custom_categories);

         return json_encode($categories);
      }
   }

   //Get Subcategories for Vue axios endpoint
   public function getSubcategoriesFromId($id, $worker_id) 
   {
      $data = ['id' => $id];
      $rules = [
         'id' => ['required', new CheckID(Default_subcategory::class, Subcategory::class)],
      ];
      $validator = Validator::make($data, $rules);
      if ($validator->fails()) {
         return redirect()->back()->withErrors($validator);
      }

      if($worker_id == Helper::worker())
      {
         $default_subcategories = Default_subcategory::where('category_id', $id)->get();

         $custom_subcategories = Subcategory::where('worker_id', $worker_id)->where('custom_category_id', $id)
            ->whereNull('is_subcategory_deleted')
            ->get();
         
         $subcategories = $default_subcategories->merge($custom_subcategories);

         return json_encode($subcategories);
      }
   }

   //Get Pozicija for Vue axios endpoint
   public function getPozicijaFromId($id, $worker_id) 
   {
      $data = ['id' => $id];
      $rules = [
         'id' => ['required', new CheckID(Default_pozicija::class, Pozicija::class)],
      ];
      $validator = Validator::make($data, $rules);
      if ($validator->fails()) {
         return redirect()->back()->withErrors($validator);
      }

      if($worker_id == Helper::worker())
      {
         $default_pozicija = Default_pozicija::where('subcategory_id', $id)
            ->join('units', 'pozicija.unit_id', '=', 'units.id_unit')
            ->get();

         $custom_pozicija = Pozicija::where('worker_id', $worker_id)->where('custom_subcategory_id', $id)
            ->whereNull('is_pozicija_deleted')
            ->join('units', 'custom_pozicija.unit_id', '=', 'units.id_unit')
            ->get();
         
         $pozicija = $default_pozicija->merge($custom_pozicija);


         return json_encode($pozicija);
      }

   }

   private function mergedData($worker_id)
   {   
      $counter = auth('worker')->user()->ponuda_counter ?? -1;

      $ponuda = Ponuda::select(
               'ponuda.id',
               'ponuda.service_id',
               'ponuda.quantity',
               'ponuda.unit_price',
               'ponuda.categories_id',
               'ponuda.work_type_id',
               'wt.name AS work_type_name',
               'c_wt.name AS custom_work_type_name',
               'c.name AS name_category',
               'c_c.name AS name_custom_category',
               'u.name AS unit_name',
               'poz.title',
               'poz.description',
               'c_poz.title AS custom_title',
               'c_poz.description AS custom_description',
               'temp.temporary_description',
               'title.temporary_title',
               'serv.name_service',
         )
         ->leftJoin('work_types as wt', 'ponuda.work_type_id', '=', 'wt.id')
         ->leftJoin('categories as c', 'ponuda.categories_id', '=', 'c.id')
         ->leftJoin('pozicija as poz', 'ponuda.pozicija_id', '=', 'poz.id')
         ->leftJoin('custom_work_types as c_wt', 'ponuda.work_type_id', '=', 'c_wt.id')
         ->leftJoin('custom_categories as c_c', 'ponuda.categories_id', '=', 'c_c.id')
         ->leftJoin('custom_pozicija as c_poz', 'ponuda.pozicija_id', '=', 'c_poz.id')
         ->join('units as u', function ($join) {
            $join->on('poz.unit_id', '=', 'u.id_unit')
               ->orWhere(function ($query) {
                     $query->on('c_poz.unit_id', '=', 'u.id_unit');
               });
         })
         ->leftJoin('pozicija_temporary as temp', 'ponuda.id', '=', 'temp.id_of_ponuda')
         ->leftJoin('title_temporary as title', 'ponuda.id', '=', 'title.id_of_ponuda')
         ->join('services as serv', 'ponuda.service_id', '=', 'serv.id_service')
         ->where('ponuda.ponuda_id', $counter)
         ->where('ponuda.worker_id', $worker_id)
         ->whereNull('c_wt.is_work_type_deleted')
         ->whereNull('c_c.is_category_deleted')
         ->whereNull('c_poz.is_pozicija_deleted')
         ->get();

      return $ponuda;
   }

   public function storePonuda(Request $request)
   {
      try {
         $request->validate([
            'worktype' => ['required', new CheckID(Default_work_type::class, Work_type::class)],
            'category' => ['required', new CheckID(Default_category::class, Category::class)],
            'subcategory' => ['required', new CheckID(Default_subcategory::class, Subcategory::class)],
            'pozicija' => ['required', new CheckID(Default_pozicija::class, Pozicija::class)],
            'quantity' => ['required','integer','gt:0','digits_between:1,7'],
            'price' => ['required','numeric','gt:0','regex:/^\d{1,8}(\.\d{1,2})?$/'],
            'radioButton' => 'required|in:1,2',
            'opis' => 'nullable|regex:/\p{L}/u',
            'edit_des' => 'nullable|regex:/\p{L}/u',
        ]);

        $billion = 1000000000;
         if($request->input('quantity') * $request->input('price') < $billion)
         {
            $worker_id = Helper::worker();
            $swap = Swap::join('workers', 'swap_ponuda.worker_id', '=', 'workers.id')
               ->where('workers.id', $worker_id)
               ->first();  
            $counter = $swap!==null?$swap->swap_id:auth('worker')->user()->ponuda_counter;
            $des = $request->input('edit_des') ?? "&nbsp;";
            $title = $request->input('edit_title') ?? "";
            $pozicija_id = $request->input('pozicija');

            $new_ponuda = Ponuda::create([
               'worker_id' => $worker_id,
               'ponuda_id' => $counter,
               'work_type_id' => $request->input('worktype'),
               'categories_id' => $request->input('category'),
               'subcategories_id' => $request->input('subcategory'),
               'pozicija_id' => $request->input('pozicija'),
               'service_id' => $request->input('radioButton'),
               'quantity' => $request->input('quantity'),
               'unit_price' => $request->input('price'),
            ]);

            $db = Default_pozicija::select('id', 'description', 'title')
               ->where('id', $pozicija_id)
               ->first();      
            $custom_db = Pozicija::select('id', 'description', 'title')
               ->where('id', $pozicija_id)
               ->first();      
            $id_of_ponuda = $new_ponuda->id;      
            $default_desc = $db!==null?$db->description:$custom_db->description;
            $default_title = $db!==null?$db->title:$custom_db->title;

            if($des != $default_desc)
            {
               Pozicija_Temporary::create([
                  'id_of_ponuda' => $id_of_ponuda,
                  'temporary_description' => $des,
            ]);      
            }
            if($title != $default_title)
            {
               Title_Temporary::create([
                  'id_of_ponuda' => $id_of_ponuda,
                  'temporary_title' => $title,
            ]);
            }
            
            session()->forget('opis_ponude');
            session()->put('opis_ponude', $request->input('opis'));

            return redirect(route("worker.new.ponuda"))->with('msg', 'added'); 
         }
         else
         {
            Alert::error(__('app.controllers.something-went-wrong'))->showCloseButton()->showConfirmButton(__('app.basic.close'));
            return redirect(route("worker.new.ponuda"));
         }
       } catch (Exception) {
            Alert::error(__('app.controllers.something-went-wrong'))->showCloseButton()->showConfirmButton(__('app.basic.close'));
            return redirect(route("worker.new.ponuda"));
       }
   }

   public function updateDescription(Request $request)
   {
      $request->validate([
         'real_id' => ['required','exists:App\Models\Ponuda,id'],
         'new_radioButton' => ['required','in:1,2'],
         'new_quantity' => ['required','integer','gt:0','digits_between:1,7'],
         'new_unit_price' => ['required','numeric','gt:0','regex:/^\d{1,8}(\.\d{1,2})?$/'],
         'new_title' => ['required','string'],
         'new_description' => ['nullable','string'],
      ]);

      $billion = 1000000000;
      if($request->input('new_quantity') * $request->input('new_unit_price') < $billion)
      {
         $temp = $request->input('new_description') ?? "&nbsp;";
         $title = $request->input('new_title');
         $id = $request->input('real_id');

         $ponuda = Ponuda::where('id', $id)->where('worker_id', Helper::worker())->first();

         $ponuda_desc = Ponuda::join('pozicija_temporary as temp', 'ponuda.id', '=', 'temp.id_of_ponuda')
            ->where('ponuda.id', $id)
            ->where('ponuda.worker_id', Helper::worker())
            ->first();

         if($ponuda_desc)
         {
            Pozicija_Temporary::where('id_of_ponuda', $id)->update([
               'temporary_description' => $temp,
            ]);
         }
         else
         {
            Pozicija_Temporary::create([
               'id_of_ponuda' => $id,
               'temporary_description' => $temp,
            ]);
         }

         $ponuda_title = Ponuda::join('title_temporary as temp', 'ponuda.id', '=', 'temp.id_of_ponuda')
            ->where('ponuda.id', $id)
            ->where('ponuda.worker_id', Helper::worker())
            ->first();

         if($ponuda_title)
         {
            Title_Temporary::where('id_of_ponuda', $id)->update([
               'temporary_title' => $title,
            ]);
         }
         else
         {
            Title_Temporary::create([
               'id_of_ponuda' => $id,
               'temporary_title' => $title,
            ]);
         }

         Ponuda::where('id', $id)->update([
            'service_id' => $request->input('new_radioButton'),
            'quantity' => $request->input('new_quantity'),
            'unit_price' => $request->input('new_unit_price'),
         ]);
      }
      return redirect()->route('worker.new.ponuda');
   }

   public function ponudaDone(Request $request)
   {
      
      $request->validate([
         'ponuda_name' => 'required|min:3|max:64',
         'opis' => 'nullable',
         'note' => 'nullable|max:64'
      ]);

      $worker_id = Helper::worker();
      if($this->checkPonudaDone($worker_id) !== null){
         $ponuda_name = $request->input('ponuda_name');
         $swap = Swap::join('workers', 'swap_ponuda.worker_id', '=', 'workers.id')
            ->where('workers.id', $worker_id)
            ->first();  
         if($swap!==null)
         {
            Worker::where('id', $worker_id)->update(['ponuda_counter' => $swap->original_id]);        
            $p_date = Ponuda_Date::updateOrCreate(
            [
               'worker_id' => $worker_id,
               'id_ponuda' => $swap->swap_id
            ],
            [
               'worker_id' => $worker_id,
               'id_ponuda' => $swap->swap_id,
               'ponuda_name' => [
                  'sr' => Helper::transliterate($ponuda_name,"sr"),
                  'rs-cyrl' => Helper::transliterate($ponuda_name,"rs-cyrl")
               ],
               'note' => [
                  'sr' => Helper::transliterate($request->input('note'),"sr",1),
                  'rs-cyrl' => Helper::transliterate($request->input('note'),"rs-cyrl",1)
               ],
               'opis' => [
                  'sr' => Helper::transliterate($request->input('opis'),"sr",1),
                  'rs-cyrl' => Helper::transliterate($request->input('opis'),"rs-cyrl",1)
               ],
            ]);
   
            if (!$p_date->wasRecentlyCreated) {
               $p_date->updated_at = now();
               $p_date->save();
            }
   
            Swap::where('worker_id', $worker_id)->delete();
         }
         else
         {
            Ponuda_Date::create([
               'worker_id' => $worker_id,
               'id_ponuda' => auth('worker')->user()->ponuda_counter,
               'ponuda_name' => [
                  'sr' => Helper::transliterate($ponuda_name,"sr"),
                  'rs-cyrl' => Helper::transliterate($ponuda_name,"rs-cyrl")
               ],
               'note' => [
                  'sr' => Helper::transliterate($request->input('note'),"sr",1),
                  'rs-cyrl' => Helper::transliterate($request->input('note'),"rs-cyrl",1)
               ],
               'opis' => [
                  'sr' => Helper::transliterate($request->input('opis'),"sr",1),
                  'rs-cyrl' => Helper::transliterate($request->input('opis'),"rs-cyrl",1)
               ],
            ]);         
            auth('worker')->user()->increment('ponuda_counter');
            Worker::where('id', $worker_id)->update(['ponuda_counter' => auth('worker')->user()->ponuda_counter]);
         }

         Helper::updateFreeTrial('count_offers');

         if ($request->input('edit')) {
            Alert::success(__('app.create-ponuda.ponuda-changed'))->showCloseButton()->showConfirmButton(__('app.basic.close'));
            return redirect(route("worker.new.ponuda"));
         }

         session()->forget('opis_ponude');
         
         Alert::success(__('app.create-ponuda.ponuda-created'))->showCloseButton()->showConfirmButton(__('app.basic.close'));
         return redirect(route("worker.new.ponuda"));
      }
      else
      {
         Alert::error(__('app.create-ponuda.no-data-ponuda'))->showCloseButton()->showConfirmButton(__('app.basic.close'));
         return redirect(route("worker.new.ponuda"));  
      }
   }

   private function checkPonudaDone($worker)
   {
      $swap = Swap::join('workers', 'swap_ponuda.worker_id', '=', 'workers.id')
         ->where('workers.id', $worker)
         ->first();

      if ($swap!==null) {
         return Ponuda::where('worker_id', $worker)
            ->where('ponuda_id', $swap->swap_id)
            ->first();
      } else {
         return Ponuda::where('worker_id', $worker)
            ->where('ponuda_id', auth('worker')->user()->ponuda_counter)
            ->first();
      }

      return null;
   }
   
   public function deletePonuda(Request $request){
      $request->validate([
         'id' => ['required','exists:App\Models\Ponuda,id']
      ]);
      
      Ponuda::where('id', $request->input('id'))
         ->where('worker_id', Helper::worker())
         ->delete();
      Alert::success(__('app.controllers.ponuda-element-is-deleted'))->showCloseButton()->showConfirmButton(__('app.basic.close'));
      return redirect(route("worker.new.ponuda"));
   }

   public function profile()
   {
    return view('profile');
   }

   public function postcreate()
   {
    return view('postcreate');
   }
}
