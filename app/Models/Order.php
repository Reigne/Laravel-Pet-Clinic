<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	protected $table = 'orderinfo';
 	protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $fillable = ['customer_id', 'status'];
    
    public function customer() {
    	return $this->belongsTo('App\Models\Customer');
    }

    public function groomings() {
    	return $this->belongsToMany(Grooming::class,'orderline','orderinfo_id','grooming_id');
 	}
}