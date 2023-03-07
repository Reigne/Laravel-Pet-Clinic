<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use softDeletes;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Customer extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $guarded = ['id', 'imagePath'];
    protected $fillable = ['user_id', 'title', 'fname', 'lname', 'addressline', 'zipcode', 'town', 'phone', 'imagePath'];

    public $searchableType = 'Customer Searched';

    public function getSearchResult(): SearchResult
     {
        $url = url('show-customer/'.$this->id);
     
         return new \Spatie\Searchable\SearchResult(
            $this,
            $this->customer_name,
            $url
            );
     }

    public function users() {
	 	return $this->belongsTo('App\Models\User');
	}

    public function pets() {
        return $this->hasMany('App\Models\Pet', 'customer_id');
    }

    public function reviews() {
        return $this->hasMany('App\Models\Review', 'customer_id');
    }

    public function orders() {
        return $this->hasMany('App\Models\Order', 'customer_id');
    }
}
