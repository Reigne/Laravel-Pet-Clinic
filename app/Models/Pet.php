<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pet extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id', 'imagePath'];
    protected $fillable = ['customer_id', 'name', 'species', 'breed', 'color', 'age', 'gender', 'imagePath'];

    public $searchableType = 'Pet Searched';

    public function getSearchResult(): SearchResult
     {
        $url = url('show-pet/'.$this->id);
     
         return new \Spatie\Searchable\SearchResult(
            $this,
            $this->pet_name,
            $url
            );
     }

     public function customers() {
	 	return $this->belongsTo('App\Models\Customer', 'customer_id');
	}

    public function consulations() {
        return $this->hasMany('App\Models\Consulation', 'pet_id');
    }
}
