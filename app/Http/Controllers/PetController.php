<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pet;
use View;   
use Redirect;
use DB;
use App\Models\Customer;
use App\DataTables\PetsDataTable;
use Storage;
use File;
use Yajra\DataTables\Html\Builder;
use Yajra\Datatables\Datatables;
use Excel;
use App\Imports\PetImport;
use App\Rules\ExcelRule;
use Auth;

class PetController extends Controller
{	


    public function create()
    {
        $customers = Customer::select("id", DB::raw("CONCAT(fname, ' ' , lname) AS name"))->pluck('name','id');
        return View::make('pet.create',compact('customers'));
    }

    public function store(Request $request)
     {
        $input = $request->all();

        // $request->validate([
        //     'imagePath' => 'mimes:jpeg,png,jpg,gif,svg'
        // ]);

        if($file = $request->hasFile('image')) {
            
            $file = $request->file('image') ;
            $fileName = $file->getClientOriginalName();
            // dd($fileName);
            $request->image->storeAs('images', $fileName, 'public');
            $input['imagePath'] = 'images/'.$fileName;
            $pet = Pet::create($input);
        }

        if (Auth::user()->role == 'customer'){
            // dd($pet);
            return redirect::to('profile')->with('success','Pet Created Successfully!');
        }  else {
           return \Redirect::to('/pet')->with('success','Pet Created Successfully!');
        }
    }

    public function edit($id)
    {
       $pet = Pet::find($id);

       $customers = Customer::select("id", DB::raw("CONCAT(fname, ' ' , lname) AS name"))->pluck('name', 'id');
       // dd($customers);
       return View::make('pet.edit',compact('pet', 'customers'));
    }

    public function update(Request $request, $id)
    {
        $pet = Pet::find($id);
       
        $input = $request->all();

        if($file = $request->hasFile('image')) {
        $path = Storage::putFileAs('images/pet', $request->file('image'),$request->file('image')->getClientOriginalName());
        $request->merge(["imagePath"=>$request->file('image')->getClientOriginalName()]);

        $file = $request->file('image') ;
        $fileName = $file->getClientOriginalName();
        $destinationPath = public_path().'/images' ;
        $input['imagePath'] = 'images/'.$fileName;     
        $pet->update($input);
        // dd($pet);
        $file->move($destinationPath,$fileName);
        } else{
            $pet->update($input);
        }
        return \Redirect::to('/pet')->with('success','Pet Updated Successfully!');
    }

    public function destroy($id)
    {
        $pet = Pet::find($id);
        $pet->delete();

        return Redirect::route('getPets')->with('success','Pet Deleted!');
    }

     public function getPets(PetsDataTable $dataTable) {
        $pets =  Pet::with('customers')->get();
        // dd($pets);
        return $dataTable->render('pet.index');
    }


	public function import(Request $request) {
        
         $request->validate([
        'pet_upload' => ['required', new ExcelRule($request->file('pet_upload'))],
    ]);
        // dd($request);
        Excel::import(new PetImport, request()->file('pet_upload'));
        
        return redirect()->back()->with('success', 'Excel file Imported Successfully');
    }

}
