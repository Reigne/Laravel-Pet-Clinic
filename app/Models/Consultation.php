<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $fillable = ['pet_id', 'employee_id', 'comment', 'price'];

    public function conditions() {
	 	return $this->belongsToMany('App\Models\Condition');
	}

    public function pets() {
	 	return $this->belongsTo('App\Models\Pet');
	}

	public function employees() {
	 	return $this->belongsTo('App\Models\Employee');
	}
}
