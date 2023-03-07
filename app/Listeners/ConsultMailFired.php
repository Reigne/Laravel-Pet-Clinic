<?php

namespace App\Listeners;

use Illuminate\Http\Request;
use App\Events\ConsultMail;
// use Illuminate\Contracts\Queue\ShouldQueue;
// use Illuminate\Queue\InteractsWithQueue;
use App\Models\Consultation;
use App\Models\Condition;
use Mail;

class ConsultMailFired
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        // dd($event);
        $pet = Consultation::join('pets', 'pets.id', '=', 'consultations.pet_id')
        ->join('customers', 'customers.id','=','pets.customer_id')
        ->join('users', 'users.id','=','customers.user_id')
        ->select('users.email', 'customers.fname', 'customers.lname', 'pets.name', 'consultations.price', 'consultations.comment', 'consultations.created_at')
        ->where('consultations.id', '=', $event->consult->id)
        ->first(); 
        // dd($pet); 

        $consultations = Consultation::where('consultations.id', '=', $event->consult->id)
        ->with('conditions')
        ->get();
        // $conditions = Consultation::with(['conditions' => function($query) use($event){
        //     $query->where("consultations.id", '=' ,$event->consult->id);
        // }])->where('consultations.id', '=', $event->consult->id)->get();
    // dd($consultations); 
// dd($conditions); 
        // dd($pet); 
        Mail::send( 'email.consult_notification', 
            compact('pet','consultations'),
            function($message) use ($pet) {
            $message->from('acmeclinic@clinic.ph','Admin');
            // dd($listener);
            $message->to($pet->email, $pet->name);
            $message->subject('AcmeClinic Consultation');
            // $message->attach(public_path('/images/logo.jpg'));
        });
    }
}
