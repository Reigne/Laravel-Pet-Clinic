<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id', 'imagePath'];
    protected $fillable = ['user_id', 'title', 'fname', 'lname', 'addressline', 'zipcode', 'town', 'phone', 'imagePath'];

   	public $searchableType = 'Employee Searched';

   	public function getSearchResult(): SearchResult
     {
        $url = url('show-employee/'.$this->id);
     
         return new \Spatie\Searchable\SearchResult(
            $this,
            $this->fname,
            $url
            );
     }

    public function users() {
	 	return $this->belongsTo('App\Models\User', 'user_id');
	}

    public function consulations() {
        return $this->hasMany('App\Models\Consulation', 'employee_id');
    }
}	
