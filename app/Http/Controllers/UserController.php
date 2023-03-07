<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\User;
use App\Models\Customer;
// use Illuminate\Support\Facades\Mail;
// use App\Mail\SignupMail;
use Auth;
use Redirect;
use Storage;

use App\Events\SendMail;
use Event;
use App\Listeners\SendMailFired;
use App\Models\Order;

class UserController extends Controller
{
   	public function getSignup(){
        return view('user.signup');
    }

    public function postSignup(Request $request){
        $this->validate($request, [
            'email' => 'email| required| unique:users',
            'password' => 'required| min:4'
        ]);

        $user = new User([
            'name' => $request->input('fname').' '.$request->lname,
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);
        // dd($user);

        $user->role = 'customer';
        $user->save();

            if($file = $request->hasFile('image')) {
            $path = Storage::putFileAs('images/customer', $request->file('image'),$request->file('image')->getClientOriginalName());

            $request->merge(["imagePath"=>$request->file('image')->getClientOriginalName()]);
        	$file = $request->file('image') ;
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
            
            //Mail
            Event::dispatch(new SendMail($user));
            // return Redirect::back()->with('success','Email sent successfully!');
            }   

            Auth::login($user);
            return redirect()->route('user.profile')->with('success', 'Account has been created and Email has been sent!');
        
    }

    public function getEmployee(){
        return view('user.signup-employee');
    }

    public function signupEmployee(Request $request){
        $this->validate($request, [
            'email' => 'email| required| unique:users',
            'password' => 'required| min:4'
        ]);

        $user = new User([
            'name' => $request->input('fname').' '.$request->lname,
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);

        $user->role = 'employee';
        $user->save();

        if($file = $request->hasFile('image')) {
            $path = Storage::putFileAs('images/employee', $request->file('image'),$request->file('image')->getClientOriginalName());

            $request->merge(["imagePath"=>$request->file('image')->getClientOriginalName()]);

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

            Auth::login($user);
            return redirect()->route('user.employee')->with('success', 'Account has been created!');
    }

    public function getProfile(){


        if (Auth::check() && Auth::user()->role == "admin") {
            return view('user.employee');
        }
        elseif (Auth::check() && Auth::user()->role == "customer"){

        $customer = Customer::where('user_id',Auth::id())->first();
        $orders = Order::with('customer','groomings')->where('customer_id',$customer->id)->orderBy('id','DESC')->paginate(5);

        $pets = Auth::user()->customers->pets->all();

        // dd($orders);
        // $user = User::with('customers')->find(Auth::id());
        // dd(Auth::user()->customers->fname);
        return view('user.profile', compact('pets', 'orders'));
        }
        else{
        return view('user.employee');
        }
    }

    public function getLogout(){
        Auth::logout();
        return redirect('/shop');
    }

    public function getSignin(){
        return view('user.signin');
    }
        
    // public function postSignin(Request $request){
    //     $this->validate($request, [
    //         'email' => 'email| required',
    //         'password' => 'required| min:4'
    //     ]);
    //      if(Auth::attempt(['email' => $request->input('email'),'password' => $request->input('password')])) {
    //         return redirect()->route('user.profile');
    //     }else{
    //         return redirect()->back();
    //     };
    //  }
}
