<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\User;
use App\DataTables\EmployeesDataTable;
use Yajra\DataTables\Html\Builder;
use Yajra\Datatables\Datatables;
use App\Imports\EmployeeImport;
use App\Rules\ExcelRule;
use View;   
use Redirect;
use DB;
use Storage;
use File;
use Excel;

class EmployeeController extends Controller
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
        return View::make('employee.create');
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
            'password' => 'required| min:3',
        ]);

        try {

        $user = new User([
            'name' => $request->input('fname').' '.$request->lname,
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password'))
        ]);

        $user->save();

        $path = Storage::putFileAs('images/employee', $request->file('image'),$request->file('image')->getClientOriginalName());

        $request->merge(["imagePath"=>$request->file('image')->getClientOriginalName()]);

        if($file = $request->hasFile('image')) {
            $file = $request->file('image') ;
            $fileName = $file->getClientOriginalName();
            $destinationPath = public_path().'/images' ;
            
            $employee = new Employee;

            $employee->user_id = $user->id; 
            $employee->title = $request->title;
            $employee->fname = $request->fname;
            $employee->lname = $request->lname;
            $employee->addressline = $request->addressline;
            $employee->zipcode = $request->zipcode;
            $employee->town = $request->town;
            $employee->phone = $request->phone;
            $employee->imagePath= 'images/'.$fileName;
            $employee->save();
            $file->move($destinationPath,$fileName);
        }
        }
        catch (\Exception $e) {
            // dd($e);
            return Redirect::to('/employee')->with('failed','Employee Failed to Create!');
        }

        // dd($employee);
        return Redirect::to('/employee')->with('success','Employee Created Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = Employee::find($id);
        $users = User::with('employees')->where('id', $employee->user_id)->get();

        return View::make('employee.edit', compact('employee', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   
        // $this->validate($request, [
        //     'password' => 'required| min:4'
        // ]);

        $employee = Employee::find($id);
        $employee->update($request->all());

        $input = $request->all();

        if($file = $request->hasFile('image')) {
        $path = Storage::putFileAs('images/employee', $request->file('image'),$request->file('image')->getClientOriginalName());    
        $request->merge(["imagePath"=>$request->file('image')->getClientOriginalName()]);    
        
        $file = $request->file('image') ;
        $fileName = $file->getClientOriginalName();
        $destinationPath = public_path().'/images' ;
        $input['imagePath'] = 'images/'.$fileName;            
        $employee->update($input);
        $user = User::find($employee->user_id);
        $input['password']  =  bcrypt($request->input('password'));   
        $user->update($input);
        $file->move($destinationPath,$fileName);
        
        } else {
            $employee->update($input);
            $user = User::find($employee->user_id);
            $input['password']  =  bcrypt($request->input('password'));   
            $user->update($input);
        } 

        return \Redirect::to('/employee')->with('success','Employee Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employee::find($id);

        // $employee->users()->delete();
        $user = User::where('id',$employee->user_id)->delete();
        // dd($customer);
        $employee->delete();
        
        return Redirect::route('getEmployees')->with('success','Employee Deleted Successfully!');
    }

    public function forceDelete($id){
        $employee = Employee::find($id);
        // $customer->users($customer->user_id)->delete();
        
        $user = User::where('id',$employee->user_id)->forceDelete();
        $employee->forceDelete();
        return Redirect::route('getEmployees')->with('success','Employee has been Deleted!');
    }


    public function restore($id) {
        $employee = Employee::withTrashed()->find($id);
        // dd($customer);$customer = Customer::withTrashed()->find($id);
        $user = User::where('id',$employee->user_id)->restore();
        $employee->restore();
        // ->restore();
        return  Redirect::route('getEmployees')->with('success','Employee restored successfully!');
    }

    public function getEmployees(EmployeesDataTable $dataTable) {
        $employees = Employee::withTrashed()->with('users')->get();
        // dd($employees->user->role);
        return $dataTable->render('employee.index');
    }

    public function import(Request $request) {
        $request->validate(['employee_upload' => ['required', new ExcelRule($request->file('employee_upload'))],
    ]);
        // dd($request);
        Excel::import(new   EmployeeImport, request()->file('employee_upload'));
        
        return redirect()->back()->with('success', 'Excel file Imported Successfully');
    }

}
