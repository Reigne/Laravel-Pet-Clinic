<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consultation;
use App\Models\Pet;
use App\Models\User;
use App\Models\Condition;
use App\DataTables\ConsultationsDataTable;
use Yajra\DataTables\Html\Builder;
use Yajra\Datatables\Datatables;
use Auth;
use View;   
use Redirect;
use DB;
use Storage;
use File;
use Excel;
use App\Events\ConsultMail;
use Event;
use App\Listeners\ConsultMailFired;


class ConsultationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $conditions = Condition::get();
        $pets = Pet::select("id", "name")->pluck('name', 'id');
        // $conditions = Condition::select("id", "description")->pluck('description', 'id');
        // dd($condition);
        return View::make('consulation.create', compact('pets', 'conditions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $input = $request->all();
        
        $input['employee_id'] = Auth::user()->employees->id; 
        $consult = Consultation::create($input);

        if(!(empty($request->condition_id))){
            $consult->conditions()->attach($request->condition_id);
        }

        Event::dispatch(new ConsultMail($consult));
        
        return redirect()->route('getConsultations')->with('success', 'Consultation Created Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getConsultations(ConsultationsDataTable $dataTable) {
        $consultations =  Consultation::with(['employees','pets','conditions'])->get();
        // dd($consultation);
        return $dataTable->render('consulation.index');
    }
}
