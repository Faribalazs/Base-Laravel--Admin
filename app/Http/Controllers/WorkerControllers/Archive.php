<?php

namespace App\Http\Controllers\WorkerControllers;

use App\Models\{Swap, Ponuda, Ponuda_Date, Pozicija_Temporary, Title_Temporary, Worker, Fizicko_lice, Pravno_lice, Company_Data, Fizicko_lice_Temporary, Pravno_lice_Temporary};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Helpers\Helper;
use App\Jobs\SendEmail;
use Illuminate\Support\Facades\Validator;
use App\Rules\Ponuda_PonudaID;

class Archive extends Controller
{
    public function create()
    {   
        session()->forget('client_id');
        session()->forget('ponuda_id');
        session()->forget('temporary');
        session()->forget('type');

        return view('worker.views.archive.archive',[
            'data' => Ponuda_Date::where('worker_id', Helper::worker())
                ->orderBy('created_at', 'DESC')
                ->get()
        ]);
    }

    public function search(Request $request)
    {
        $sortOrder = $request->input('sort_order', 'desc');
        $searchQuery = '%'.$request->input('query').'%';
        $search_data = $request->input('query');

        return view('worker.views.archive.archive',[
            'data' => Ponuda_Date::where('worker_id', Helper::worker())
                ->where('ponuda_name', 'LIKE', $searchQuery)
                ->orderBy('created_at', $sortOrder)
                ->get(), 
            'sort' => $sortOrder, 
            'search_data' => $search_data
        ]);
    }

    public function searchNapomena(Request $request)
    {
        $sortOrder = $request->input('sort_order', 'desc');
        $searchQuery = '%'.$request->input('query').'%';
        $search_data = $request->input('query');
  
        return view('worker.views.archive.archive',[
            'data' => Ponuda_Date::where('worker_id', Helper::worker())
                ->where('note', 'LIKE', $searchQuery)
                ->orderBy('created_at', $sortOrder)
                ->get(), 
            'sort' => $sortOrder, 
            'search_data_napomena' => $search_data
        ]);
    }

    private function ponudaInfo($id, $worker_id){
        return Ponuda::where('ponuda_id', $id)->where('worker_id',$worker_id);
    }

    private function ponudaDate($id, $worker_id){
        return Ponuda_Date::where('id_ponuda', $id)->where('worker_id',$worker_id);
    }

    private function temporaryDesc($id){
        return Pozicija_Temporary::where('id_of_ponuda', $id)->delete();
    }

    private function temporaryTitle($id){
        return Title_Temporary::where('id_of_ponuda', $id)->delete();
    }

    public function delete(Request $request)
    {
        $request->validate([
            'id' => ['required', new Ponuda_PonudaID],
        ]);

        $id = $request->input('id');
        $worker_id = Helper::worker();
        $ponuda = Ponuda::select('id', 'worker_id', 'ponuda_id')->where('worker_id', $worker_id)->where('ponuda_id', $id)->get();
        foreach($ponuda as $toDel)
        {
            $this->temporaryDesc($toDel->id);
            $this->temporaryTitle($toDel->id);
        }
        $this->ponudaDate($id, $worker_id)->delete();
        $this->ponudaInfo($id, $worker_id)->delete();
        return redirect()->route('worker.archive');
    }

    public function deleteElement(Request $request)
    {
        $request->validate([
            'real_id' => ['required', new Ponuda_PonudaID],
            'id' => ['required', 'exists:App\Models\Ponuda,id']
        ]);

        $worker_id = Helper::worker();
        $id = $request->input('id');
        $ponuda_id = $request->input('real_id');
        $this->ponudaInfo($ponuda_id,$worker_id)->where('id', $id)->delete();
        $this->temporaryDesc($id);
        if($this->ponudaInfo($ponuda_id,$worker_id)->count()<1)
        {
            $this->ponudaDate($ponuda_id,$worker_id)->delete();
            return redirect()->route('worker.archive');
        }
        
        return redirect()->route('worker.archive.selected',['id' => $ponuda_id]);
    }
    
    private function mergedData(){
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
            ->where('ponuda.worker_id', Helper::worker());
            
            return $ponuda;
    }

    public function selectedArchive($id)
    {
        //validator
        $data = ['id' => $id];
        $rules = [
            'id' => ['required', new Ponuda_PonudaID],
        ];
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $worker_id = Helper::worker();
        $mergedData = $this->mergedData()->where('ponuda.ponuda_id', $id)->get()->sortBy('ponuda.id');
        $ponuda_name = Ponuda_Date::select('ponuda_name', 'created_at', 'updated_at', 'opis', 'id_ponuda')->where('worker_id', $worker_id)->where('id_ponuda', $id)->first();
        
        return view('worker.views.archive.archive-selected',['mergedData' => $mergedData, 'ponuda_name' => $ponuda_name, 'ponuda_id' => $id]);
    }

    private function PDFname($id, $worker)
    {
        return Ponuda_Date::select('ponuda_name', 'opis')->where('worker_id', $worker)->where('id_ponuda', $id)->first();
    }

    public function viewPDF($id) {
        //validator
        $data = ['id' => $id];
        $rules = [
            'id' => ['required', new Ponuda_PonudaID],
        ];
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        list($pdf, $pdf_name) = $this->PDFdata($id);
        return $pdf->stream($pdf_name->ponuda_name);
    }

    private function company_data($worker_id)
    {
        return Company_Data::where('worker_id', $worker_id)->first();
    }

    private function fizickaLica($worker)
    {
        return Fizicko_lice::where('worker_id', $worker)->get();
    }

    private function pravnaLica($worker)
    {
        return Pravno_lice::where('worker_id', $worker)->get();
    }

    private function selectedFizicka($worker, $id)
    {
        return Fizicko_lice::where('worker_id', $worker)->where('id', $id)->first();
    }
    private function selectedFizickaTemporary($worker, $id)
    {
        return Fizicko_lice_Temporary::where('worker_id', $worker)->where('id', $id)->first();
    }
    private function selectedPravna($worker, $id)
    {
        return Pravno_lice::where('worker_id', $worker)->where('id', $id)->first();
    }
    private function selectedPravnaTemporary($worker, $id)
    {
        return Pravno_lice_Temporary::where('worker_id', $worker)->where('id', $id)->first();
    }

    public function selectContact($id){
        session()->forget('client_id');
        session()->forget('ponuda_id');
        session()->forget('temporary');
        session()->forget('type');
        return view('worker.views.generate-pdf.select-contact',['id' => $id]);
    }

    public function showLice($lice,$id)
    {
        if ($lice == 'individual') {
            return view('worker.views.generate-pdf.add-new-or-select-contact',['id' => $id, 'lice' => $lice, 'fizicka_lica' => $this->fizickaLica(Helper::worker())]);
        }

        if ($lice == 'legal-entity') {
            return view('worker.views.generate-pdf.add-new-or-select-contact',['id' => $id, 'lice' => $lice, 'pravna_lica' => $this->pravnaLica(Helper::worker())]);
        }
    }

    public function contactOrForm($lice,$method,$id)
    {
        if ($lice == 'individual' && $method == 'contact') {
            return view('worker.views.generate-pdf.fizicka-lica',['id' => $id, 'lice' => $lice, 'method' => $method, 'fizicka_lica' => $this->fizickaLica(Helper::worker())]);
        } elseif ($lice == 'individual' && $method == 'add_new') {
            return view('worker.views.generate-pdf.fizicka-lica',['id' => $id, 'lice' => $lice, 'method' => $method]);
        }

        if ($lice == 'legal-entity' && $method == 'contact') {
            return view('worker.views.generate-pdf.pravna-lica',['id' => $id, 'lice' => $lice, 'method' => $method, 'pravna_lica' => $this->pravnaLica(Helper::worker())]);
        } elseif ($lice == 'legal-entity' && $method == 'add_new') {
            return view('worker.views.generate-pdf.pravna-lica',['id' => $id, 'lice' => $lice, 'method' => $method]);
        }
    }

    public function selectTempleteCreate(){

        return view('worker.views.generate-pdf.select-tamplate');
    }

    public function submitContact(Request $request){
        if($request->input('method') !== null && $request->input('method') == 'contact') {
            if ($request->input('fizicko_id') != null) {
                session(['client_id'=> $request->input('fizicko_id')]);
                session(['ponuda_id' => $request->input('ponuda_id')]);
                session(['type' => 1]);

                return redirect()->route('worker.archive.select.template');
                
            } else {
                Alert::error(__('app.controllers.choose-one-contact'))->showCloseButton()->showConfirmButton(__('app.basic.close'));
                return redirect()->back();
            }

        } elseif($request->input('method') !== null && $request->input('method') == 'add_new') {
            $f_name = $request->input('f_name');
            $l_name = $request->input('l_name');
            $grad = $request->input('grad');
            $postcode = $request->input('postcode');
            $adresa = $request->input('adresa');
            $email = $request->input('email');
            $tel = $request->input('tel'); 

            $data = $request->validate([
                'f_name' => 'required | max:30 | regex:/\p{L}/u',
                'l_name' => 'required | max:30 | regex:/\p{L}/u',
                'grad' => 'required | max:30 | regex:/\p{L}/u',
                'postcode' => 'required | max:10 | regex:/^[0-9]+$/',
                'adresa' => 'required | max:50 | regex:/\p{L}/u',
                'email' => ['required','string','email:rfc','max:255'],
                'tel' => 'required | max:25 | regex:/^([0-9\s\-\+\(\)]*)$/',
                'ponuda_id' => ['required', new Ponuda_PonudaID],
            ],
            [
                '*.required' => trans("app.errors.profile-required"),
                'postcode.regex' => trans("app.errors.profile-only-numbers"),
                'email.email' => trans("app.errors.profile-email"),
            ]);

            if($request->input('save') !== null)
                {
                    $client = Fizicko_lice::updateOrCreate(
                        [
                            'worker_id' => Helper::worker(),
                            'email' => $email
                        ],
                        [
                            'worker_id' => Helper::worker(),
                            'first_name' => [
                                'sr' => Helper::transliterate($f_name,"sr"),
                                'rs-cyrl' => Helper::transliterate($f_name,"rs-cyrl")
                            ],
                            'last_name' => [
                                'sr' => Helper::transliterate($l_name,"sr"),
                                'rs-cyrl' => Helper::transliterate($l_name,"rs-cyrl")
                            ],
                            'city' => [
                                'sr' => Helper::transliterate($grad,"sr"),
                                'rs-cyrl' => Helper::transliterate($grad,"rs-cyrl")
                            ],
                            'zip_code' => $postcode,
                            'address' => [
                                'sr' => Helper::transliterate($adresa,"sr"),
                                'rs-cyrl' => Helper::transliterate($adresa,"rs-cyrl")
                            ],
                            'email' => $email,
                            'phone' => $tel,
                        ]
                    );
                    $temporary = false;
                    Alert::success(__('app.basic.successfully-added'))->showCloseButton()->showConfirmButton(__('app.basic.close'));
                }
            else{
                $client = Fizicko_lice_Temporary::updateOrCreate(
                    [
                        'worker_id' => Helper::worker()
                    ],
                    [
                        'first_name' => $f_name,
                        'last_name' => $l_name,
                        'city' => $grad,
                        'zip_code' => $postcode,
                        'address' => $adresa,
                        'email' => $email,
                        'tel' => $tel,
                    ]
                );
                $temporary = true;
            }
            session(['client_id' => $client ? $client->id : null]);
            session(['ponuda_id' => $request->input('ponuda_id')]);
            session(['temporary' => $temporary]);
            session(['type' => 1]);

            return redirect()->route('worker.archive.select.template');
        }
        Alert::error(__('app.controllers.something-went-wrong'))->showCloseButton()->showConfirmButton(__('app.basic.close'));
        return redirect()->back();
    }

    public function submitContactPravna(Request $request){
        if($request->input('method') !== null && $request->input('method') == 'contact') {
            if ($request->input('pravno_id') != null) {
                session(['client_id'=> $request->input('pravno_id')]);
                session(['ponuda_id' => $request->input('ponuda_id')]);
                session(['type' => 2]);

                return redirect()->route('worker.archive.select.template');
            } else {
                Alert::error(__('app.controllers.choose-one-contact'))->showCloseButton()->showConfirmButton(__('app.basic.close'));
                return redirect()->back();
            }
        } elseif($request->input('method') !== null && $request->input('method') == 'add_new') {
            $company_name = $request->input('company');
            $grad = $request->input('grad');
            $postcode = $request->input('postcode');
            $adresa = $request->input('adresa');
            $email = $request->input('email');
            $tel = $request->input('tel'); 
            $pib = $request->input('pib'); 

            $data = $request->validate([
                'company' => 'required | max:50 | regex:/\p{L}/u',
                'grad' => 'required | max:30 | regex:/\p{L}/u',
                'postcode' => 'required | max:10 | regex:/^[0-9]+$/',
                'adresa' => 'required | max:50 | regex:/\p{L}/u',
                'email' => ['required','string','email:rfc','max:255'],
                'tel' => 'required | max:25 | regex:/^([0-9\s\-\+\(\)]*)$/',
                'pib' => 'max:30 | regex:/^[0-9\-]+$/',
                'ponuda_id' => ['required',new Ponuda_PonudaID],
             ],
             [
                '*.required' => trans("app.errors.profile-required"),
                'postcode.regex' => trans("app.errors.profile-only-numbers"),
                'email.email' => trans("app.errors.profile-email"),
                'pib.regex' => trans("app.errors.profile-only-numbers"),
             ]);

            if($request->input('save') !== null)
            {
                $client = Pravno_lice::updateOrCreate(
                    [
                        'worker_id' => Helper::worker(),
                        'email' => $email
                    ],
                    [
                        'worker_id' => Helper::worker(),
                        'company_name' => [
                            'sr' => Helper::transliterate($company_name,"sr"),
                            'rs-cyrl' => Helper::transliterate($company_name,"rs-cyrl")
                        ],
                        'city' => [
                            'sr' => Helper::transliterate($grad,"sr"),
                            'rs-cyrl' => Helper::transliterate($grad,"rs-cyrl")
                        ],
                        'zip_code' => $postcode,
                        'address' => [
                            'sr' => Helper::transliterate($adresa,"sr"),
                            'rs-cyrl' => Helper::transliterate($adresa,"rs-cyrl")
                        ],
                        'email' => $email,
                        'phone' => $tel,
                        'pib' => $pib,
                    ]
                );
                $temporary = false;
                Alert::success(__('app.basic.successfully-added'))->showCloseButton()->showConfirmButton(__('app.basic.close'));
            }
            else{
                $client = Pravno_lice_Temporary::updateOrCreate(
                    [
                        'worker_id' => Helper::worker()
                    ],
                    [
                        'worker_id' => Helper::worker(),
                        'company_name' => $company_name,
                        'city' => $grad,
                        'zip_code' => $postcode,
                        'address' => $adresa,
                        'email' => $email,
                        'tel' => $tel,
                        'pib' => $pib,
                    ]
                );
                $temporary = true;
            }

            session(['client_id' => $client ? $client->id : null]);
            session(['ponuda_id' => $request->input('ponuda_id')]);
            session(['temporary' => $temporary]);
            session(['type' => 2]);

            return redirect()->route('worker.archive.select.template');
        }
        Alert::error(__('app.controllers.something-went-wrong'))->showCloseButton()->showConfirmButton(__('app.basic.close'));
        return redirect()->back();
    }

    public function createGeneratePdf() 
    {
        return view('worker.views.generate-pdf.generate-pdf-success');
    }

    public function redirctToGeneratePdf(Request $request) 
    {
        $request->validate([
            'ponuda_id' => ['required', new Ponuda_PonudaID],
            'client_id' => ['nullable','numeric','gt:0'],
            'type' => ['required','in:1,2'],
            'temp' => ['required','in:template-one,default'],
        ]);

        session(['temp' => $request->input('temp')]);
        
        return redirect()->route('worker.archive.genarte.tamplate.pdf.create');
    }

    public function tamplateGeneratePdf(Request $request) 
    {
        $request->validate([
            'ponuda_id' => ['required', new Ponuda_PonudaID],
            'client_id' => ['required','numeric','gt:0'],
            'type' => ['required','in:1,2'],
            'temp' => ['required','in:template-one,default'],
        ]);

        $worker_id = Helper::worker();
        $company_data = $this->company_data($worker_id) ?? null;
        $template = $request->input('temp');
        if($company_data === null && $template == "template-one")
            return redirect()->route('worker.personal.data');
        $pdf_blade = 'worker.pdf.'. $template;
        $id = $request->input('ponuda_id');
        $type_id = $request->input('type');
        $client_id = $request->input('client_id') ?? null;
        $pdf_name = $this->PDFname($id,$worker_id);
        $selectedWorkerPonuda = $this->mergedData()->where('ponuda_id', $id)->get();
        $foundClient = null;

        if ($type_id && $client_id) {
            if($type_id == 1)
            {
                if($request->input('temporary'))
                {
                    $foundClient = $this->selectedFizickaTemporary($worker_id, $client_id);
                }
                else
                {
                    $foundClient = $this->selectedFizicka($worker_id, $client_id);
                }
            }
            elseif($type_id == 2)
            {
                if($request->input('temporary'))
                {
                    $foundClient = $this->selectedPravnaTemporary($worker_id, $client_id);
                }
                else
                {
                    $foundClient = $this->selectedPravna($worker_id, $client_id);
                }
            }
            else
                return redirect()->route('worker.archive');

            if($request->input('skini'))
            {
                if(auth('worker')->user()->send_email_on_download)
                {
                    //job
                    $auto_msg = "This mail is autogenerated. Please do not respond.";
                    $data = ['pdf_blade' => $pdf_blade, 'mergedData' => $selectedWorkerPonuda, 'ponuda_name' => $pdf_name->ponuda_name ?? "Ponuda", 'company' => $company_data, 'client' => $foundClient, 'type' => $type_id, 'opis' => $pdf_name->opis];
                    $emailJob = (new SendEmail(auth('worker')->user()->email, null, null, $data, $pdf_name->ponuda_name, $auto_msg));
                    dispatch($emailJob)->delay(\Carbon\Carbon::now()->addMinutes(1));
                }
                $pdf = PDF::loadView($pdf_blade,['mergedData' => $selectedWorkerPonuda, 'ponuda_name' => $pdf_name->ponuda_name ?? "Ponuda", 'company' => $company_data, 'client' => $foundClient, 'type' => $type_id, 'opis' => $pdf_name->opis]);
                if (isset($pdf_name->ponuda_name)) {
                    return $pdf->download($pdf_name->ponuda_name . '.pdf');
                } else {
                    return $pdf->download('Ponuda.pdf');
                }
            }
            elseif($request->input('posalji'))
            {
                return view('worker.views.generate-pdf.send-with-mail',['name' => $pdf_name->ponuda_name ?? "Ponuda", 'id' => $id, 'client_id' => $client_id, 'type' => $type_id, 'temporary' => $request->input('temporary'), 'pdf_blade' => $pdf_blade, 'mailTo' => $foundClient->email]);
            }
        }

        return redirect()->back();
    }

    public function sendPDF(Request $request)
    {
        $request->validate([
            'mailTo' => 'required|string|email:rfc|max:255',
            'mailSubject' => 'nullable|string|max:64',
            'mailBody' => 'nullable|string|max:1024',
            'id' => ['required', new Ponuda_PonudaID],
            'client_id' => 'nullable|numeric|gt:0',
            'type' => 'required|in:1,2',
        ]);

        $worker_id = Helper::worker();
        $company_data = $this->company_data($worker_id) ?? null;
        $pdf_blade = $request->input('pdf');
        $id = $request->input('id');
        $type_id = $request->input('type');
        $client_id = $request->input('client_id') ?? null;
        $pdf_name = $this->PDFname($id,$worker_id);
        $selectedWorkerPonuda = $this->mergedData()->where('ponuda_id', $id)->get();
        $foundClient = null;

        if ($type_id && $client_id) {
            if($type_id == 1)
            {
                if($request->input('temporary'))
                {
                    $foundClient = $this->selectedFizickaTemporary($worker_id, $client_id);
                }
                else
                {
                    $foundClient = $this->selectedFizicka($worker_id, $client_id);
                }
            }
            elseif($type_id == 2)
            {
                if($request->input('temporary'))
                {
                    $foundClient = $this->selectedPravnaTemporary($worker_id, $client_id);
                }
                else
                {
                    $foundClient = $this->selectedPravna($worker_id, $client_id);
                }
            }
            else
                return redirect()->back();
        }

        $auto_msg = "This mail is autogenerated and has been sent by ".auth('worker')->user()->email." . Please do not respond.";
        $dataPDF = ['pdf_blade' => $pdf_blade, 'mergedData' => $selectedWorkerPonuda, 'ponuda_name' => $pdf_name->ponuda_name ?? "Ponuda", 'company' => $company_data, 'client' => $foundClient, 'type' => $type_id, 'opis' => $pdf_name->opis];
        $emailJobFirst = (new SendEmail($request->input('mailTo'), $request->input('mailSubject'), $request->input('mailBody'), $dataPDF, $pdf_name->ponuda_name, $auto_msg));
        dispatch($emailJobFirst);
        if(auth('worker')->user()->send_email_on_send)
        {
            $auto_msg = "This mail is autogenerated. You sent this email to ".$request->input('mailTo')." . Please do not respond.";
            $emailJobSecond = (new SendEmail(auth('worker')->user()->email, $request->input('mailSubject'), $request->input('mailBody'), $dataPDF, $pdf_name->ponuda_name, $auto_msg));
            dispatch($emailJobSecond);
        }
        Alert::success(__('app.controllers.successfully-sent'))->showCloseButton()->showConfirmButton(__('app.basic.close'));
        return redirect()->route('worker.archive');
    }

    private function PDFdata($id)
    {
        $worker_id = Helper::worker();
        $selectedWorkerPonuda = $this->mergedData()->where('ponuda_id', $id)->get() ?? null;
        $pdf_name = $this->PDFname($id,$worker_id);
        $pdf = PDF::loadView('worker.pdf.default',['mergedData' => $selectedWorkerPonuda, 'ponuda_name' => $pdf_name->ponuda_name, 'opis' => $pdf_name->opis]);
        return array($pdf, $pdf_name);
    }

    public function editPonuda($ponuda_id){
        //validator
        $data = ['ponuda_id' => $ponuda_id];
        $rules = [
            'ponuda_id' => ['required', new Ponuda_PonudaID],
        ];
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $workerId = Helper::worker();
        $ponuda_date = Ponuda_Date::where('worker_id', $workerId)->where('id_ponuda', $ponuda_id)->first();

        Swap::where('worker_id', $workerId)->delete();

        Swap::create([
            'worker_id' => $workerId,
            'original_id' => auth('worker')->user()->ponuda_counter,
            'swap_id' => $ponuda_id,
            'temp_ponuda_name' => $ponuda_date->ponuda_name,
            'temp_opis' => $ponuda_date->opis,
            'temp_note' => $ponuda_date->note,
        ]);
        Worker::where('id', $workerId)->update(['ponuda_counter' => $ponuda_id]);
        return redirect()->route('worker.new.ponuda');
    }

    public function FillUgovor()
    {
        $client_id = session('client_id') ?? null;
        $worker_id = Helper::worker();
        $company_data = $this->company_data($worker_id) ?? null;
        $type_id = session('type') ?? null;
        $id = session('ponuda_id') ?? null;
        if(empty($client_id) || empty($type_id) || empty($id))
            return redirect()->back();
        $foundClient = null;
        $sum = 0;
        foreach(Ponuda::select('quantity','unit_price')->where('ponuda_id', $id)->where('worker_id', Helper::worker())->get() as $ponuda)
        {
            $sum += $ponuda->quantity * $ponuda->unit_price;
        }
        if ($type_id && $client_id) {
            if($type_id == 1)
            {
                if(session('temporary'))
                {
                    $foundClient = $this->selectedFizickaTemporary($worker_id, $client_id);
                }
                else
                {
                    $foundClient = $this->selectedFizicka($worker_id, $client_id);
                }
            }
            elseif($type_id == 2)
            {
                if(session('temporary'))
                {
                    $foundClient = $this->selectedPravnaTemporary($worker_id, $client_id);
                }
                else
                {
                    $foundClient = $this->selectedPravna($worker_id, $client_id);
                }
            }
            else {
                return redirect()->route('worker.archive');
            }

            if($company_data == null) {
                Alert::warning(__('app.controllers.fill-company-data-first'))->showCloseButton()->showConfirmButton(__('app.basic.close'));
                return redirect()->route('worker.personal.data');
            }

            $pdv = $sum * 0.2;
            $sum += $pdv;
            $sum = ceil($sum);
            $lang = null;
            if(app()->getLocale() == "sr")
            {
                $lang = "sr_Latn_RS";
            }
            elseif(app()->getLocale() == "rs-cyrl")
            {
                $lang = "sr_RS";
            }
            else
            {
                return redirect()->back();
            }
            $digit = new \NumberFormatter($lang, \NumberFormatter::SPELLOUT);
            $sum_in_words = $digit->format($sum);
            $mailTo = $foundClient->email;
        }
        if ($type_id == 1) {
            return view('worker.views.generate-pdf.fill-up-contract-fizicko-lice', compact(['foundClient', 'company_data', 'id', 'sum', 'sum_in_words', 'mailTo']));
        }elseif ($type_id == 2) {
            return view('worker.views.generate-pdf.fill-up-contract-pravno-lice', compact(['foundClient', 'company_data', 'id', 'sum', 'sum_in_words', 'mailTo']));
        }

        return redirect()->back();
    }

    public function contractPdf()
    {
        $pdf = PDF::loadView('worker.pdf.empty-contract-individual');
        return $pdf->download('empty-contract.pdf');
    }

    public function UgovorGeneratePDF(Request $request)
    {
        $ugovorBr = $request->input('br');
        $fields = [];

        $type = session('type') == 1 ? 1 : 0;
        if(session('type') != 2 && !$type)
        {
            return redirect()->back();
        }

        for ($i = 1; $i <= 25+$type; $i++) {
            $fields[] = $request->input('field' . $i);
        }

        if($type)
        {
            $pdf_blade = 'worker.pdf.contract-individual'; 
        }
        else
        {
            $pdf_blade = 'worker.pdf.contract-legal-entity';
        }

        $fields[13+$type] = $this->formatDateToSerbian($fields[13+$type]);

        if($request->input('skini'))
        {
            $pdf = PDF::loadView($pdf_blade, compact('fields','ugovorBr'));
            return $pdf->download(($ugovorBr ?? 'Ugovor') . '.pdf');
        }
        elseif($request->input('posalji'))
        {
            $request->validate([
                'mailTo' => ['required','string','email:rfc','max:255'],
            ]);
            return view('worker.views.generate-pdf.send-with-mail',['name' => "Ugovor", 'ugovor_br' => $ugovorBr, 'pdf_blade' => $pdf_blade, 'fields' => $fields, 'mailTo' => $request->input('mailTo')]);
        }

        return redirect()->back();
    }

    private function formatDateToSerbian($date)
    {
        $dateTime = \DateTime::createFromFormat('Y-m-d', $date);

        if ($dateTime) {
            return $dateTime->format('d/m/Y');
        }

        return $date;
    }

    public function sendPDFContract(Request $request)
    {
        $request->validate([
            'mailTo' => 'required|string|email:rfc|max:255',
            'mailSubject' => 'nullable|string|max:64',
            'mailBody' => 'nullable|string|max:1024',
            'fields' => ['required'],
            'ugovor_br' => ['nullable'],
            'pdf' => ['required'],
        ]);

        $data = json_decode(html_entity_decode($request->fields));

        if (json_last_error() != JSON_ERROR_NONE) {
            return redirect()->back();
        }

        $auto_msg = "This mail is autogenerated and has been sent by ".auth('worker')->user()->email." . Please do not respond.";
        $dataPDF = ['pdf_blade' => $request->pdf, 'mergedData' => $data, 'ponuda_name' => $request->ugovor_br];
        $emailJobFirst = (new SendEmail($request->input('mailTo'), $request->input('mailSubject'), $request->input('mailBody'), $dataPDF, null, $auto_msg));
        dispatch($emailJobFirst);

        return redirect()->route('worker.archive.fill.contract');
    }
}
