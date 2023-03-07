<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;   
use Redirect;
use DB;
use App\Models\Customer;
use App\Models\Pet;
use App\DataTables\CustomersDataTable;
use Storage;
use File;
use Yajra\DataTables\Html\Builder;
use Yajra\Datatables\Datatables;
use Excel;
use App\Imports\CustomerImport;
use App\Rules\ExcelRule;
use App\Models\User;
use Auth;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View::make('customer.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'email| required| unique:users',
            'password' => 'required| min:3'
        ]);

        $user = new User([
            'name' => $request->input('fname').' '.$request->lname,
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password'))
        ]);

        $user->save();

        $path = Storage::putFileAs('images/customer', $request->file('image'),$request->file('image')->getClientOriginalName());

        $request->merge(["imagePath"=>$request->file('image')->getClientOriginalName()]);

        if($file = $request->hasFile('image')) {
        	$file = $request->file('image');
        	$fileName = $file->getClientOriginalName();
        	$destinationPath = public_path().'/images' ;
        	
        	$customer = new Customer;

        	$customer->user_id = $user->id;	
        	$customer->title = $request->title;
        	$customer->fname = $request->fname;
        	$customer->lname = $request->lname;
        	$customer->addressline = $request->addressline;
        	$customer->zipcode = $request->zipcode;
        	$customer->town = $request->town;
        	$customer->phone = $request->phone;
        	$customer->imagePath= 'images/'.$fileName;
        	$customer->save();
        	$file->move($destinationPath,$fileName);
        }
        
        // dd($customer);
        // return redirect()->route('getCustomers');
        return Redirect::to('/customer')->with('success','Customer Created Successfully!');
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
        $customer = Customer::find($id);
        // $users = User::pluck('email','id');
        // dd($id);
        $users = User::with('customers')->where('id', $customer->user_id)->get();
        // $users = User::with('customers')->find($id)->first();
        // dd($users);


        // $customer = Customer::find($id);
        // $users = DB::table('users')
        //                     ->where('id', $id)
        //                     ->pluck('email')
        //                     ->toArray();
        // // dd($album_listener);

        // return View::make('customer.edit',compact('customer','users'));
         return View::make('customer.edit', compact('customer', 'users'));
        // return view('customer.edit',compact('customer'));
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
        $this->validate($request, [
            'password' => 'required| min:3'
        ]);

        $customer = Customer::find($id);
        $customer->update($request->all());

        $input = $request->all();
        
        if($file = $request->hasFile('image')) {
        $path = Storage::putFileAs('images/grooming', $request->file('image'),$request->file('image')->getClientOriginalName());
        $request->merge(["imagePath"=>$request->file('image')->getClientOriginalName()]);
        $file = $request->file('image') ;
        $fileName = $file->getClientOriginalName();
        $destinationPath = public_path().'/images' ;
        $input['imagePath'] = 'images/'.$fileName;            
        $customer->update($input);
        $user = User::find($customer->user_id);
        $input['password']  =  bcrypt($request->input('password'));   
        $user->update($input);
        $file->move($destinationPath,$fileName);
        } else {
            $user->update($input);
        }

        if (Auth::user()->role == 'customer'){
            return redirect::to('/profile')->with('success','Customer Updated Successfully!');
        }        
        return Redirect::to('/customer')->with('success','Customer Updated Successfully!');
                        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customer::find($id);
        $customer->pets()->delete();
        // $customer->users($customer->user_id)->delete();
        
        $user = User::where('id',$customer->user_id)->delete();
        $customer->delete();
        // dd($customer);
        
        return Redirect::route('getCustomers')->with('success','Customer has been Deactivated!');
    }

    public function forceDelete($id){
        $customer = Customer::find($id);
        $customer->pets()->forceDelete();
        // $customer->users($customer->user_id)->delete();
        
        $user = User::where('id',$customer->user_id)->forceDelete();
        $customer->forceDelete();
        return Redirect::route('getCustomers')->with('success','Customer has been Deleted!');
    }

    public function restore($id) {
        // $customer = Customer::withTrashed()->where('id',$id)->restore();
        // dd($customer);
        // ->restore();

        $customer = Customer::withTrashed()->find($id);
        $customer->pets()->restore();
        $user = User::where('id',$customer->user_id)->restore();
        $customer->restore(); 
        return Redirect::route('getCustomers')->with('success','Customer has been Restored!');
    }

     public function getCustomers(CustomersDataTable $dataTable) {
        $customers =  Customer::with(['users','pets'])->get();

        return $dataTable->render('customer.index');
    }

    public function import(Request $request) {
        
         $request->validate([
        'customer_upload' => ['required', new ExcelRule($request->file('customer_upload'))],
    ]);
        // dd($request);
        Excel::import(new CustomerImport, request()->file('customer_upload'));
        
        return redirect()->back()->with('success', 'Excel file Imported Successfully');
    }



}
