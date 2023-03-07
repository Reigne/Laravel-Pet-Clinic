<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Session;

class LoginController extends Controller
{
   public function postSignin(Request $request){
        $this->validate($request, [
            'email' => 'email| required',
            'password' => 'required| min:4'
        ]);

        if(auth()->attempt(array('email' => $request->email, 'password' => $request->password))) {

            if (auth()->user()->role === 'employee') {
                return redirect()->route('user.employee');
            } else if (auth()->user()->role === 'admin'){
             return redirect()->route('getEmployees');
            }  
            else {
                return redirect()->route('shop.index');
            }
        }
        else{
            return redirect()->route('user.signin')->with('error','Email-Address And Password Are Wrong.');
        }
     }
     public function logout(){
        Auth::logout();
        Session::forget('cart');
        return redirect()->route('user.signin');
    }
}