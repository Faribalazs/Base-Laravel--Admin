<?php

namespace App\Http\Controllers\WorkerControllers;

use App\Models\{Work_type, Category, Subcategory, Pozicija, Default_work_type, Default_category, Default_subcategory, Units};
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use App\Helpers\Helper;
use App\Rules\CheckID;

class NewOptions extends Controller
{
   //custom category create & store start

   public function WorkTypeCreate()
   {
      return view('worker.views.my-categories.add-new-work-type');
   }

   public function store_worktype(Request $request)
   {
      $request->validate([
         'work_type_name_sr' => ['required','max:64','string'],
      ],
      [
         '*.required' => trans("app.errors.no-category-name"),
      ]);

      $work_type_name_sr = $request->input('work_type_name_sr');

      Work_type::create([
         'worker_id' => Helper::worker(),
         'name' => [
            'sr' => Helper::transliterate($work_type_name_sr, "sr"),
            'rs-cyrl' => Helper::transliterate($work_type_name_sr, "rs-cyrl"),
         ],
      ]);

      Helper::updateFreeTrial('count_my_categories');

      Alert::success(__('app.basic.successfully-added'))->showCloseButton()->showConfirmButton(__('app.basic.close'));
      return redirect(route('worker.options.update'));  
   }
   
   public function CategoryCreate()
   {
      return view('worker.views.my-categories.add-new-category', ['work_types' => Default_work_type::all(), 'custom_work_types' => $this->custom_WorkTypes()]);
   }


   public function store_category(Request $request)
   {
      $request->validate([
         'category_name_sr' => ['required','max:64','string'],
         'work_type' => ['required', new CheckID(Default_work_type::class, Work_type::class)]
      ],
      [
         '*.required' => trans("app.errors.no-category-name"),
      ]);

      $category_name_sr = $request->input('category_name_sr');

      Category::create([
         'worker_id' => Helper::worker(),
         'name' => [
            'sr' => Helper::transliterate($category_name_sr, "sr"),
            'rs-cyrl' => Helper::transliterate($category_name_sr, "rs-cyrl"),
         ],
         'custom_work_type_id' => $request->input('work_type')
      ]);

      Helper::updateFreeTrial('count_my_categories');

      Alert::success(__('app.basic.successfully-added'))->showCloseButton()->showConfirmButton(__('app.basic.close'));
      return redirect(route('worker.options.update'));  
   }
   //custom category create & store end

   //custom subcategory create & store start
   private function custom_WorkTypes()
   {
      return Work_type::where('worker_id', Helper::worker())->whereNull('is_work_type_deleted')->get();
   }
   
   private function custom_Categories()
   {
      return Category::where('worker_id', Helper::worker())->whereNull('is_category_deleted')->get();
   }

   private function custom_Subcategories()
   {
      return Subcategory::where('worker_id', Helper::worker())->whereNull('is_subcategory_deleted')->get();
   }

   public function SubCategoryCreate()
   {
      return view('worker.views.my-categories.add-new-subcategory',['categories' => Default_category::all(), 'custom_categories' => $this->custom_Categories()]);
   }

   public function store_subcategory(Request $request)
   {
      $request->validate([
         'subcategory_name_sr' => 'required|max:64|regex:/^[a-z\s]+$/i',
         'category' => ['required', new CheckID(Default_category::class, Category::class)],
      ],
      [
         'category.required' => trans("app.errors.no-category-selected"),
         'subcategory_name_sr.required' => trans("app.errors.no-subcategory-name"),
      ]);
   
      Subcategory::create([
         'worker_id' => Helper::worker(),
         'custom_category_id' => $request->input('category'),
         'name' => [
            'sr' => Helper::transliterate($request->input('subcategory_name_sr'),"sr"),
            'rs-cyrl' => Helper::transliterate($request->input('subcategory_name_sr'),"rs-cyrl"),
         ],
      ]);

      Helper::updateFreeTrial('count_my_categories');

      Alert::success(__('app.basic.successfully-added'))->showCloseButton()->showConfirmButton(__('app.basic.close'));
      return redirect(route('worker.options.update'));  
   }
   
   //custom subcategory create & store end

   //custom pozicija create & store start

   public function pozicijaCreate()
   {
      return view('worker.views.my-categories.add-new-pozicija',['categories' => Default_category::all(), 'custom_categories' => $this->custom_Categories(), 'subcategories' => Default_subcategory::all(), 'custom_subcategories' => $this->custom_Subcategories(), 'units'=> Units::all()]);
   }

   public function store_pozicija(Request $request)
   {
      $request->validate([
         'subcategory' => ['required', new CheckID(Default_subcategory::class, Subcategory::class)],
         'pozicija_name_sr' => ['required','string'],
         'poz_des_sr' => ['nullable','string'],
         'unit_id' => ['required','exists:App\Models\Units,id_unit'],
      ],
      [
         'subcategory.required' => trans("app.errors.no-subcategory-selected"),
         'pozicija_name_sr.required' => trans("app.errors.no-pozicija-name"),
         'poz_des_sr.required' => trans("app.errors.no-pozicija-des"),
         'unit_id.required' => trans("app.errors.no-unit-selected"),
      ]);

      Pozicija::create([
         'worker_id' => Helper::worker(),
         'custom_subcategory_id' => $request->input('subcategory'),
         'unit_id' => $request->input('unit_id'),
         'title' => [
            'sr' => Helper::transliterate($request->input('pozicija_name_sr'),"sr"),
            'rs-cyrl' => Helper::transliterate($request->input('pozicija_name_sr'),"rs-cyrl"),
         ],
         'description' => [
            'sr' => Helper::transliterate($request->input('poz_des_sr'),"sr"),
            'rs-cyrl' => Helper::transliterate($request->input('poz_des_rs_cyrl'),"rs-cyrl"),
         ],
      ]);

      Helper::updateFreeTrial('count_my_categories');

      Alert::success(__('app.basic.successfully-added'))->showCloseButton()->showConfirmButton(__('app.basic.close'));
      return redirect(route('worker.options.update'));  
   }

   //custom pozicija create & store start
}
