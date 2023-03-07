<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Grooming;

class GroomingImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            $grooming = new Grooming();
            $grooming->description = $row['description'];
            $grooming->price = $row['price'];
			$grooming->imagePath = $row['image'];
            $grooming->save();
        }
    }
}
