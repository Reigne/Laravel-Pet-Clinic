<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Customer;
use App\Models\User;

class CustomerImport implements ToCollection, WithHeadingRow
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

            $customer = new Customer();
            $customer->user_id = $user->id;
            $customer->title = $row['title'];
			$customer->fname = $row['fname'];
			$customer->lname = $row['lname'];
			$customer->addressline = $row['addressline'];
			$customer->town = $row['town'];
			$customer->zipcode = $row['zipcode'];
			$customer->phone = $row['phone'];
			$customer->imagePath = $row['image'];

            $customer->save();
        }
    }
}
