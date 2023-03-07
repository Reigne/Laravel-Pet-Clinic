<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// admin middleware
Route::group(['middleware' => 'role:admin'], function() {

//Customer Route
Route::delete('/customer/forceDelete/{id}',[
  'uses' => 'CustomerController@forceDelete',
  'as' => 'customer.forceDelete'
]);

Route::resource('customer', 'CustomerController');

Route::get('/customer', [
      'uses' => 'CustomerController@getCustomers',
       'as' => 'getCustomers'
    ]);

Route::post('/customer/import', 'CustomerController@import')->name('customerImport');

Route::get('/customer/restore/{id}',[
  'uses' => 'CustomerController@restore',
  'as' => 'customer.restore'
]);


//Pet Route
Route::resource('pet', 'PetController');
// Route::resource('pet', 'PetController')->except(['index','delete','update']);

Route::get('/pet', [
      'uses' => 'PetController@getPets',
       'as' => 'getPets'
    ]);

Route::post('/pet/import', 'PetController@import')->name('petImport');

Route::get('/pet/restore/{id}',['uses' => 'PetController@restore','as' => 'pet.restore']);


//Employee Route
Route::resource('employee', 'EmployeeController');

Route::get('/employee', [
      'uses' => 'EmployeeController@getEmployees',
       'as' => 'getEmployees'
    ]);

Route::delete('/employee/forceDelete/{id}',[
  'uses' => 'EmployeeController@forceDelete',
  'as' => 'employee.forceDelete'
]);

Route::post('/employee/import', 'EmployeeController@import')->name('employeeImport');

Route::get('/employee/restore/{id}',['uses' => 'EmployeeController@restore','as' => 'employee.restore']);

//Grooming Route
Route::resource('grooming', 'GroomingController');

Route::get('/grooming', [
      'uses' => 'GroomingController@getGroomings',
       'as' => 'getGroomings'
    ]);

Route::post('/grooming/import', 'GroomingController@import')->name('groomingImport');

Route::get('/grooming/restore/{id}',['uses' => 'GroomingController@restore','as' => 'grooming.restore']);


}); // end of Admin middleware



Route::group(['middleware' => 'role:customer,admin,employee'], function() {
     Route::get('profile', [
    'uses' => 'UserController@getProfile',
    'as' => 'user.profile',
    ]);


    Route::resource('pet', 'PetController')->only(['create', 'store']);
    Route::resource('customer', 'CustomerController')->only(['edit','update']);

  });





// Middleware for profile employee and admin
Route::group(['middleware' => 'role:employee,admin'], function() {

    Route::get('profile-employee', [
    'uses' => 'UserController@getProfile',
    'as' => 'user.employee',
    ]);

    Route::get('order-transaction', [
      'uses' => 'GroomingController@getOrders',
       'as' => 'getOrders'
    ]);

    Route::get('/order-status/edit/{id}','GroomingController@orderStatus')->name('order.edit');
    Route::post('/order-status/update/{id}',['uses' => 'GroomingController@orderUpdate','as' => 'order.update']);

    //consultations
    Route::resource('consultation', 'ConsultationController');
    Route::get('consultation', [
      'uses' => 'ConsultationController@getConsultations',
       'as' => 'getConsultations'
    ]);

    //dashboard
Route::get('/dashboard',[
  'uses'=>'DashboardController@index',
  'as'=>'dashboard.index']);

Route::get('/dashboard-search',[
  'uses'=>'DashboardController@index',
  'as'=>'search']);
}); // end of profile and admin



//User Route and middleware for guest
Route::group(['prefix' => 'user'], function() {
  Route::group(['middleware' => 'guest'], function() {
  
  //signup customer
  Route::get('signup', [
    'uses' => 'userController@getSignup',
    'as' => 'user.signups',
  ]);

  Route::post('signup', [
    'uses' => 'userController@postSignup',
    'as' => 'user.signup',
  ]);

  //signup employee
  Route::get('signup-employee', [
    'uses' => 'userController@getEmployee',
    'as' => 'user.signupEmployees',
  ]);

  Route::post('signup-employee', [
    'uses' => 'userController@signupEmployee',
    'as' => 'user.signupEmployee',
  ]);

  Route::get('signin', [
    'uses' => 'userController@getSignin',
    'as' => 'user.signins',
  ]);

  Route::post('signin', [
    'uses' => 'LoginController@postSignin',
    'as' => 'user.signin',
  ]);
  });

 });

   
Route::get('logout',[
  'uses' => 'LoginController@logout',
  'as' => 'user.logout',
  'middleware'=>'auth'
 ]);

   
Route::fallback(function () {
    return redirect()->back();
});

//shop route
Route::get('/grooming/review/{id}','GroomingController@show')->name('shop.review');

Route::post('/grooming/reviewStore',['uses' => 'GroomingController@reviewStore','as' => 'grooming.reviewStore']);

Route::get('/shop', [
    'uses' => 'GroomingController@index',
    'as' => 'shop.index'
    ]);

Route::get('add-to-cart/{id}',[
  'uses' => 'GroomingController@getAddToCart',
  'as' => 'grooming.addToCart'
]);

Route::get('shopping-cart', [
  'uses' => 'GroomingController@getCart',
  'as' => 'grooming.shoppingCart'
    // 'middleware' =>'role:customer'
]);

Route::get('checkout',[
  'uses' => 'GroomingController@postCheckout',
  'as' => 'checkout',
  'middleware' =>'role:customer'
]);

Route::get('reduce/{id}',[
  'uses' => 'GroomingController@getReduceByOne',
  'as' => 'grooming.reduceByOne'
]);

Route::get('remove/{id}',[
  'uses'=>'GroomingController@getRemoveItem',
  'as' => 'grooming.remove'
]);

