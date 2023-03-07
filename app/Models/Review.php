<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

   	public $guarded = ['id'];
   	public $fillable = ['customer_id', 'grooming_id', 'comment'];

   	public function customers() {
	 	return $this->belongsToMany('App\Models\Customer', 'customer_id');
	}

	 public function groomings() {
	 	return $this->belongsToMany('App\Models\Grooming', 'grooming_id');
	}
}
