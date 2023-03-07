<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SignupMail extends Mailable
{
      use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
   public function __construct($data)
    {
        // dd($data);
        $this->data = $data;
    }

    public function build()
    {
        // return $this->view('mail')->with('data', $this->data);
        
        // return $this->from('administrator@bands.ph')->subject('new review')->view('mail')->with('data', $this->data);

        return $this->from($this->data->sender)->subject($this->data->title)->view('mail')->with('data', $this->data);

          // return $this->from($this->data['sender'])->subject($this->data['title'])->view('mail')->with('data', $this->data);


    }
}
