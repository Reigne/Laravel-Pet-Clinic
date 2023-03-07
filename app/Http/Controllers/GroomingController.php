<?php

namespace App\Http\Controllers;

use App\Models\Grooming;
use Illuminate\Http\Request;
use View;   
use Redirect;
use DB;
use App\DataTables\GroomingsDataTable;
use App\DataTables\OrdersDataTable;
use Storage;
use File;
use Yajra\DataTables\Html\Builder;
use Yajra\Datatables\Datatables;
use Excel;
use App\Imports\GroomingImport;
use App\Rules\ExcelRule;
use App\Models\Review;
use App\Models\Customer;
use App\Models\Pet;
use App\Models\Order;
use Auth;
use Session;
use App\Cart;
use Carbon\Carbon;
use PDF;

class GroomingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groomings= Grooming::get();
        $groomings = Grooming::orderBy('id')->paginate(6);
        // dd($groomings);
        return view('shop.index', compact('groomings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $groomings = Grooming::pluck('description','id');
        return View::make('grooming.create',compact('groomings'));
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
            'price' => 'required| numeric'
        ]);

        $input = $request->all();

        $request->validate([
            'imagePath' => 'mimes:jpeg,png,jpg,gif,svg'
        ]);

        if($file = $request->hasFile('image')) {
            $file = $request->file('image') ;
            $fileName = $file->getClientOriginalName();
            // dd($fileName);
            $request->image->storeAs('images', $fileName, 'public');
            $input['imagePath'] = 'images/'.$fileName;
            $grooming = Grooming::create($input);
        } else {
            $grooming = Grooming::create($input);
        }

       return Redirect::to('/grooming')->with('success','Grooming Created Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Grooming  $grooming
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        $groomings = Grooming::find($id);
        $reviews = Review::join('customers', 'customers.id', '=', 'reviews.customer_id')
        ->join('groomings','groomings.id','=','reviews.grooming_id')
        ->select('customers.imagePath', 'customers.fname', 'customers.lname', 'reviews.comment', 'reviews.created_at')
        ->where('groomings.id', '=', $id)
        ->orderBy('reviews.id', 'DESC')
        ->paginate(5);

        // dd($reviews);
        return view('shop.review',compact('reviews', 'groomings'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Grooming  $grooming
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $grooming = Grooming::find($id);
        return View::make('grooming.edit',compact('grooming'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Grooming  $grooming
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'price' => 'required| numeric'
        ]);

        $grooming = Grooming::find($id);

        $input = $request->all();

        if($file = $request->hasFile('image')) {
            $path = Storage::putFileAs('images/grooming', $request->file('image'),$request->file('image')->getClientOriginalName());
            $request->merge(["imagePath"=>$request->file('image')->getClientOriginalName()]);            
            $file = $request->file('image') ;
            $fileName = $file->getClientOriginalName();
            $destinationPath = public_path().'/images' ;
            // dd($fileName);
            $input['imagePath'] = 'images/'.$fileName;            
            $grooming->update($input);
            // dd($grooming);
            $file->move($destinationPath,$fileName);
        } else{
            $grooming->update($input);
        }
        return \Redirect::to('/grooming')->with('success','Grooming Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Grooming  $grooming
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $grooming = Grooming::find($id);
        $grooming->delete();
        return Redirect::route('getGroomings')->with('success','Grooming Deleted Successfully!');
    }

    public function getGroomings(GroomingsDataTable $dataTable) {
        $groomings =  Grooming::get();
        // dd($groomings);
        return $dataTable->render('grooming.index');
    }

    public function import(Request $request) {
        
         $request->validate([
        'grooming_upload' => ['required', new ExcelRule($request->file('grooming_upload'))],
    ]);
        // dd($request);
        Excel::import(new GroomingImport, request()->file('grooming_upload'));
        
        return redirect()->back()->with('success', 'Excel file Imported Successfully');
    }


    public function reviewStore(Request $request)
    {
        

      if(Auth::check()){

        $this->validate($request, [
            'comment' => 'required|profanity'
        ]);
        
        $reviews = new Review;
        $reviews->customer_id = Auth::user()->customers->id;
        $reviews->grooming_id = $request->grooming_id;
        $reviews->comment = $request->comment;

        // dd($reviews);
        $reviews->save();
       
        return redirect()->back()->with('success', 'Thanks for the review!');
      }

      else {
        return Redirect::route('user.signin')->with('warning', 'Please sign-in first.');
      }

    }

    public function getAddToCart(Request $request , $id){
        $grooming = Grooming::find($id);
        $oldCart = Session::has('cart') ? $request->session()->get('cart'):null;
        $cart = new Cart($oldCart);
        $cart->add($grooming, $grooming->id);
        $request->session()->put('cart', $cart);
        Session::put('cart', $cart);
        $request->session()->save();

        return redirect()->back()->with('info', 'Service has been added successfully!');
    }

    public function getCart() { 
        // $pets = Pet::select("id", "name")->pluck('name','id');

        if (!Session::has('cart')) {
            return view('shop.shopping-cart');
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        return view('shop.shopping-cart', ['groomings' => $cart->groomings, 'totalPrice' => $cart->totalPrice]);
    }

    public function getSession(){
     Session::flush();
    }

    public function postCheckout(Request $request){

        if(Auth::check()) {

        if (!Session::has('cart')) {
            return redirect()->route('grooming.shoppingCart');
        }

        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        // dd($cart);
        try {
            DB::beginTransaction();
            $order = new Order();
            $customer =  (Auth::user()->customers->id);
            $order->customer_id = $customer;
            $order->status = 'Ongoing';
            $order->save();

            foreach($cart->groomings as $groomings){
            $id = $groomings['grooming']['id'];
            $order->groomings()->attach($id);
            }
        
        $orders = Grooming::join('orderline', 'orderline.grooming_id', '=', 'groomings.id')
        ->join('orderinfo','orderinfo.id','=','orderline.orderinfo_id')
        ->join('customers','customers.id','=','orderinfo.customer_id')
        ->select('groomings.id', 'groomings.price', 'groomings.description')
        ->where('orderinfo.id', '=', $order->id)
        ->get();
        
        $data = [
            'title' => 'Receipt for AcmeClinic',
            'date' => now(),
            'total' => $cart->totalPrice,
            'name' => (Auth::user()->customers->fname).' '.(Auth::user()->customers->lname)
         ];

        // $receipt = 'receipt-'.now()->format('M-d-Y_h-i-s').'.pdf';
        // dd($receipt);

        $pdf = PDF::loadView('receipt', $data, compact('orders'));

        // $pdf = PDF::loadView('receipt', $data, compact('orders'))->setWarnings(false)->save('C:/Users/ItzReigne/Downloads'.'/'.$receipt);

        } catch (\Exception $e) {
            // dd($e);
            DB::rollback();
            // dd($order);
            return redirect()->route('grooming.shoppingCart')->with('error', $e->getMessage());
        }

        DB::commit();

        // dd($orders->id);
        Session::forget('cart');
          
        return $pdf->download('receipt.pdf');

        // return redirect()->route('grooming.shoppingCart')->with('success','Successfully Purchased Your Pet Groomings!');

        } else {
            return Redirect::route('user.signin')->with('warning', 'Please sign-in first.');
            // return view('user.signin');
        }
    }

    public function getReduceByOne($id){
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->reduceByOne($id);
         if (count($cart->grooming) > 0) {
            Session::put('cart',$cart);
        }else{
            Session::forget('cart');
        }        
        return redirect()->route('grooming.shoppingCart');
    }

    public function getRemoveItem($id){
        $oldCard = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCard);
        $cart->removeItem($id);
        if (count($cart->groomings) > 0) {
            Session::put('cart',$cart);
        }else{
            Session::forget('cart');
        }
         return redirect()->route('grooming.shoppingCart');
    }

    public function getOrders(OrdersDataTable $dataTable) {
        $orders = Order::with(['groomings', 'customer'])->get();
        // dd($orders);

        // $orders = Grooming::join('orderline', 'orderline.grooming_id', '=', 'groomings.id')
        // ->join('orderinfo','orderinfo.id','=','orderline.orderinfo_id')
        // ->join('customers','customers.id','=','orderinfo.customer_id')
        // ->select('groomings.id', 'groomings.price', 'groomings.description', 'orderinfo.status', 'orderinfo.id as orderid', 'orderinfo.created_at')
        // ->get();

        return $dataTable->render('order.index');
    }

    public function orderStatus($id)
    {
        $orderinfo = Order::find($id);
        $orders = Grooming::join('orderline', 'orderline.grooming_id', '=', 'groomings.id')
        ->join('orderinfo','orderinfo.id','=','orderline.orderinfo_id')
        ->join('customers','customers.id','=','orderinfo.customer_id')
        ->select('groomings.id', 'groomings.price', 'groomings.description', 'orderinfo.status', 'orderinfo.id', 'orderinfo.created_at')
        ->where('orderinfo.id', '=', $id)
        ->get();

    // dd($orders);

        return View::make('order.edit', compact('orders', 'orderinfo'));
    }

    public function orderUpdate(Request $request, $id)
    {

        $orderinfo = Order::find($id);

        $input = $request->all();
        $orderinfo->update($input);

        return redirect::to('/order-transaction')->with('success','Status Updated Successfully!');
    }

}
