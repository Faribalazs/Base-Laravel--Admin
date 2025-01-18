<?php

namespace App\Http\Controllers\WorkerControllers;

use App\Models\{Work_type, Category, Subcategory, Pozicija, Default_work_type, Default_category, Default_subcategory, Default_pozicija, Units};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use App\Helpers\Helper;

class OptionsController extends Controller
{
   public function create()
   {  
      $worker_id = Helper::worker();
      
      $c_worktypes = Work_type::select(
         'custom_work_types.id',
         'custom_work_types.name',
      )
      ->where('custom_work_types.worker_id', $worker_id)
      ->whereNull('custom_work_types.is_work_type_deleted')
      ->get();

      $work_types = Default_work_type::all();

      $c_categories = Category::select(
            'custom_categories.id',
            'custom_categories.name',
            'custom_categories.custom_work_type_id',
         )
         ->leftJoin('custom_subcategories as c_sc', 'c_sc.custom_category_id', '=', 'custom_categories.id')
         ->leftJoin('subcategories as sc', 'sc.category_id', '=', 'custom_categories.id')
         ->where('custom_categories.worker_id', $worker_id)
         ->whereNull('custom_categories.is_category_deleted')
         ->get();

      $categories = Default_category::select(
            'categories.id',
            'categories.name',
            'categories.work_type_id',
         )
         ->join('custom_subcategories as c_sc', 'c_sc.custom_category_id', '=', 'categories.id')
         ->join('subcategories as sc', 'sc.category_id', '=', 'categories.id')
         ->whereNull('c_sc.is_subcategory_deleted')
         ->get();

      $c_subcategories = Subcategory::select('custom_subcategories.id','custom_subcategories.name','custom_subcategories.custom_category_id')
         ->leftJoin('pozicija as p', 'p.subcategory_id', '=', 'custom_subcategories.id')
         ->leftJoin('custom_pozicija as c_p', 'c_p.custom_subcategory_id', '=', 'custom_subcategories.id')
         ->where('custom_subcategories.worker_id', $worker_id)
         ->whereNull('custom_subcategories.is_subcategory_deleted')
         ->get();

      $subcategories = Default_subcategory::select('subcategories.id','subcategories.name','subcategories.category_id')
         ->join('pozicija as p', 'p.subcategory_id', '=', 'subcategories.id')
         ->join('custom_pozicija as c_p', 'c_p.custom_subcategory_id', '=', 'subcategories.id')
         ->distinct()
         ->whereNull('c_p.is_pozicija_deleted')
         ->get();

      $custom_pozicije = Pozicija::select('id','title','custom_subcategory_id')->where('worker_id', $worker_id)
         ->whereNull('is_pozicija_deleted')
         ->get();

      $mergedIds = $subcategories->pluck('id')->toArray();
      $result = Default_category::join('subcategories as sc', 'sc.category_id', '=', 'categories.id')
         ->whereIn('sc.id', $mergedIds)
         ->select('categories.id','categories.name','categories.work_type_id')  
         ->distinct()       
         ->get();

      $custom_work_types = $c_worktypes->merge($work_types)->unique('id')->sortBy('id');      
      $custom_categories = $c_categories->merge($categories)->concat($result)->unique('id')->sortBy('id');      
      $custom_subcategories = $c_subcategories->merge($subcategories)->unique('id')->sortBy('id');

      return view('worker.views.my-categories.index', compact(['custom_work_types','custom_categories','custom_subcategories','custom_pozicije']))->with('successMsg', '')->with('name','')->with('old_name', '');
   }

   public function showWorkType($id){
      $work_type = Work_type::where('id', $id)
         ->where('worker_id', Helper::worker())
         ->whereNull('is_work_type_deleted')
         ->first();

      if($work_type != null)
      {
         return view('worker.views.my-categories.save-work-type',
         [
            'work_type' => $work_type, 
            'id' => $id
         ]);
      }

      return redirect()->back();
   }

   public function showCategory($id){
      $category = Category::where('id', $id)
         ->where('worker_id', Helper::worker())
         ->whereNull('is_category_deleted')
         ->first();
      if($category != null)
      {
         return view('worker.views.my-categories.save-category',
         [
            'category' => $category, 
            'id' => $id
         ]);
      }

      return redirect()->back();
   }

   public function showSubcategory($id){
      $subcategory = Subcategory::where('id', $id)
         ->where('worker_id', Helper::worker())
         ->whereNull('is_subcategory_deleted')
         ->first();
      if($subcategory != null)
      {
         return view('worker.views.my-categories.save-subcategory',
         [
               'subcategory' => $subcategory, 
               'id' => $id
         ]);
      }

      return redirect()->back();
   }

   public function showPozicija($id){
      $pozicija = Pozicija::where('id', $id)
         ->where('worker_id', Helper::worker())
         ->whereNull('is_pozicija_deleted')
         ->first();
      if($pozicija != null)
      {
         return view('worker.views.my-categories.save-pozicija',
         [
            'pozicija' => $pozicija, 
            'id' => $id, 
            'units' => Units::all()
         ]);
      }

      return redirect()->back();
   }

   public function updateWorkType(Request $request){
      $request->validate([
         'worktype' => ['required','min:3'],
         'id' => ['required','exists:App\Models\Work_type,id'],
      ],
      [
         '*.required' => trans("app.errors.no-category-name"),
      ]);

      $name = $request->input('worktype');
      $id = $request->input('id');
      Work_type::where('id', $id)->where('worker_id', Helper::worker())
         ->update([
            'name' => [
               'sr' => Helper::transliterate($name,"sr"),
               'rs-cyrl' => Helper::transliterate($name,"rs-cyrl")
            ]
         ]);

      Helper::updateFreeTrial('count_my_categories');

      Alert::success(__('app.controllers.successfully-saved'))->showCloseButton()->showConfirmButton(__('app.basic.close'));
      return redirect(route("worker.options.update"));
   }

   public function updateCategory(Request $request){
      $request->validate([
         'category' => ['required','min:3'],
         'id' => ['required','exists:App\Models\Category,id'],
      ],
      [
         '*.required' => trans("app.errors.no-category-name"),
      ]);

      $name = $request->input('category');
      $id = $request->input('id');
      Category::where('id', $id)->where('worker_id', Helper::worker())
         ->update([
            'name' => [
               'sr' => Helper::transliterate($name,"sr"),
               'rs-cyrl' => Helper::transliterate($name,"rs-cyrl")
            ]
         ]);

      Helper::updateFreeTrial('count_my_categories');

      Alert::success(__('app.controllers.successfully-saved'))->showCloseButton()->showConfirmButton(__('app.basic.close'));
      return redirect(route("worker.options.update"));
   }

   public function updateSubcategory(Request $request){
      $request->validate([
         'subcategory' => ['required','min:3'],
         'id' => ['required','exists:App\Models\Subcategory,id'],
      ]);

      $name = $request->input('subcategory');
      $id = $request->input('id');
      Subcategory::where('id', $id)->where('worker_id', Helper::worker())
         ->update([
            'name' => [
               'sr' => Helper::transliterate($name,"sr"),
               'rs-cyrl' => Helper::transliterate($name,"rs-cyrl")
            ]
         ]);

      Helper::updateFreeTrial('count_my_categories');

      Alert::success(__('app.controllers.successfully-saved'))->showCloseButton()->showConfirmButton(__('app.basic.close'));
      return redirect(route("worker.options.update"));
   }

   public function updatePozicija(Request $request){
      $request->validate([
         'title' => ['required','min:3'],
         'description' => ['nullable'],
         'unit' => ['required'],
         'id' => ['required','exists:App\Models\Pozicija,id'],
      ]);

      $title = $request->input('title');
      $description = $request->input('description');
      $unit = $request->input('unit');
      $id = $request->input('id');

      if(empty($description))
      {
         $finalDescription = [
            'sr' => "",
            'rs-cyrl' => ""
         ];
      }
      else
      {
         $finalDescription = [
            'sr' => Helper::transliterate($description,"sr"),
            'rs-cyrl' => Helper::transliterate($description,"rs-cyrl")
         ];
      }
      Pozicija::where('id', $id)
         ->where('worker_id', Helper::worker())
         ->update([
            'title' => [
               'sr' => Helper::transliterate($title,"sr"),
               'rs-cyrl' => Helper::transliterate($title,"rs-cyrl")
            ],
            'description' => $finalDescription,
            'unit_id' => $unit
         ]);

      Helper::updateFreeTrial('count_my_categories');

      Alert::success(__('app.controllers.successfully-saved'))->showCloseButton()->showConfirmButton(__('app.basic.close')); 
      return redirect(route("worker.options.update"));
   }

   public function deleteWorkType(Request $request){
      $request->validate([
         'id' => ['required','exists:App\Models\Work_type,id'],
      ]);

      $id = $request->input('id');
      Work_type::where('id', $id)
         ->where('worker_id', Helper::worker())
         ->update(['is_work_type_deleted' => 1]);
      $categories = Category::where('custom_work_type_id', $id)->get();
      Category::where('custom_work_type_id', $id)
         ->where('worker_id', Helper::worker())
         ->update(['is_category_deleted' => 1]);
      foreach($categories as $category)
      {
         $subcategories = Subcategory::where('custom_category_id', $category->id)->get();
         Subcategory::where('custom_category_id', $id)
            ->where('worker_id', Helper::worker())
            ->update(['is_subcategory_deleted' => 1]);
         foreach($subcategories as $subcategory)
         {
            Pozicija::where('custom_subcategory_id', $subcategory->id)
               ->where('worker_id', Helper::worker())
               ->update(['is_pozicija_deleted' => 1]);
         }      
      }

      Alert::success(__('app.controllers.deleted-category'))->showCloseButton()->showConfirmButton(__('app.basic.close'));
      return redirect(route("worker.options.update"));
   }

   public function deleteCategory(Request $request){
      $request->validate([
         'id' => ['required','exists:App\Models\Category,id'],
      ]);

      $id = $request->input('id');
      Category::where('id', $id)
         ->where('worker_id', Helper::worker())
         ->update(['is_category_deleted' => 1]);
      $subcategories = Subcategory::where('custom_category_id', $id)->get();
      Subcategory::where('custom_category_id', $id)
         ->update(['is_subcategory_deleted' => 1]);
      foreach($subcategories as $subcategory)
      {
         Pozicija::where('custom_subcategory_id', $subcategory->id)
            ->where('worker_id', Helper::worker())
            ->update(['is_pozicija_deleted' => 1]);
      }      
      Alert::success(__('app.controllers.deleted-category'))->showCloseButton()->showConfirmButton(__('app.basic.close'));
      return redirect(route("worker.options.update"));
   }

   public function deleteSubcategory(Request $request){
      $request->validate([
         'id' => ['required','exists:App\Models\Subcategory,id'],
      ]);

      $id = $request->input('id');
      Subcategory::where('id', $id)
         ->where('worker_id', Helper::worker())
         ->update(['is_subcategory_deleted' => 1]);
      Pozicija::where('custom_subcategory_id', $id)
         ->update(['is_pozicija_deleted' => 1]);      
      Alert::success(__('app.controllers.deleted-subcategory'))->showCloseButton()->showConfirmButton(__('app.basic.close'));
      return redirect(route("worker.options.update"));
   }

   public function deletePozicija(Request $request){
      $request->validate([
         'id' => ['required','exists:App\Models\Pozicija,id'],
      ]);

      $id = $request->input('id');
      Pozicija::where('id', $id)
         ->where('worker_id', Helper::worker())
         ->update(['is_pozicija_deleted' => 1]);      
      Alert::success(__('app.controllers.deleted-pozicija'))->showCloseButton()->showConfirmButton(__('app.basic.close'));
      return redirect(route("worker.options.update"));
   }
}
