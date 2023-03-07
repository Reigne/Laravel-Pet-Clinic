<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Pet;
use App\Models\Customer;


class PetImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {   


        foreach ($rows as $row) 
        {
            $customer = Customer::where('fname' , $row['fname'])->where('lname' , $row['lname'])->first();

            $pet = new Pet();
            $pet->customer_id = $customer->id;
            $pet->name = $row['name'];
			$pet->species = $row['species'];
			$pet->gender = $row['gender'];
			$pet->breed = $row['breed'];
			$pet->color = $row['color'];
			$pet->age = $row['age'];
			$pet->imagePath = $row['image'];

            $pet->save();
        }
    }
}
