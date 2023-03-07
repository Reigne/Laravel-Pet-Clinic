<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Employee;
use App\Models\User;

class EmployeeImport implements ToCollection,  WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            $user = new User();
            $user->name = $row['lname'] . " " . $row['fname'];
            $user->email = $row['email'];
            $user->role = $row['role'];
            $user->save();

            $employee = new Employee();
            $employee->user_id = $user->id;
            $employee->title = $row['title'];
			$employee->fname = $row['fname'];
			$employee->lname = $row['lname'];
			$employee->addressline = $row['addressline'];
			$employee->town = $row['town'];
			$employee->zipcode = $row['zipcode'];
			$employee->phone = $row['phone'];
			$employee->imagePath = $row['image'];
            $employee->save();
            
        }
    }   
}
