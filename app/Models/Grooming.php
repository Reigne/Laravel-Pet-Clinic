<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Grooming extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'imagePath'];
    protected $fillable = ['description', 'price', 'imagePath'];

   	public $searchableType = 'Grooming Searched';

   	public function getSearchResult(): SearchResult
     {
        $url = url('show-grooming/'.$this->id);
     
         return new \Spatie\Searchable\SearchResult(
            $this,
            $this->description,
            $url
            );
     }

    public function reviews() {
        return $this->hasMany('App\Models\Review', 'grooming_id');
    }

    public function orders() {
    return $this->belongToMany(Order::class,'orderline','orderinfo_id','grooming_id');
  }
}
